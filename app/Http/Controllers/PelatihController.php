<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use App\Models\Kegiatan;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Prestasi;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Siswa;

class PelatihController extends Controller
{
    public function index(): View
    {
        $pelatih = Auth::guard('pelatih')->user();
        $ekskuls = $pelatih->ekskuls;
        
        return view('staff.pelatih.dashboard', compact('ekskuls'));
    }

    public function show(Ekskul $ekskul): View
    {
        // Ensure this pelatih manages this ekskul
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $ekskul->load(['kegiatans', 'siswas', 'prestasis.siswa']);

        $monthlyAttendance = DB::table('presensis')
            ->join('kegiatans', 'presensis.kegiatan_id', '=', 'kegiatans.id')
            ->where('kegiatans.ekskul_id', $ekskul->id)
            ->select(
                DB::raw('strftime("%m", tanggal) as month'),
                DB::raw('strftime("%Y", tanggal) as year'),
                DB::raw('COUNT(*) as total_records'),
                DB::raw('SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as total_hadir')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $item->percentage = $item->total_records > 0 ? round(($item->total_hadir / $item->total_records) * 100, 1) : 0;
                $item->month_name = Carbon::create((int)$item->year, (int)$item->month, 1)->translatedFormat('F Y');
                return $item;
            });

        $absenteeRecap = Presensi::join('kegiatans', 'presensis.kegiatan_id', '=', 'kegiatans.id')
            ->where('kegiatans.ekskul_id', $ekskul->id)
            ->whereIn('status', ['alfa', 'izin', 'sakit'])
            ->with('siswa')
            ->select('presensis.siswa_id', 'presensis.status', DB::raw('COUNT(*) as count'))
            ->groupBy('presensis.siswa_id', 'presensis.status')
            ->get()
            ->groupBy('siswa_id');

        $absenteeDistribution = DB::table('presensis')
            ->join('kegiatans', 'presensis.kegiatan_id', '=', 'kegiatans.id')
            ->where('kegiatans.ekskul_id', $ekskul->id)
            ->whereIn('status', ['alfa', 'izin', 'sakit'])
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        return view('staff.pelatih.ekskul-detail', compact('ekskul', 'monthlyAttendance', 'absenteeRecap', 'absenteeDistribution'));
    }

    public function storeKegiatan(Request $request, Ekskul $ekskul): RedirectResponse
    {
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $request->validate([
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $ekskul->kegiatans()->create($request->all());

        return back()->with('success', 'Jadwal latihan baru berhasil ditambahkan.');
    }

    public function presensi(Kegiatan $kegiatan): View
    {
        if ($kegiatan->ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $ekskul = $kegiatan->ekskul;
        
        if ($ekskul->is_wajib) {
            // For mandatory ekskul, get all students in the specified grades
            $grades = explode(',', $ekskul->wajib_kelas);
            $siswas = Siswa::where(function($query) use ($grades) {
                foreach ($grades as $grade) {
                    $query->orWhere('kelas', 'like', trim($grade) . '%');
                }
            })->orderBy('nama')->get();
        } else {
            // For optional ekskul, get only enrolled students
            $siswas = $ekskul->siswas()->orderBy('nama')->get();
        }

        $kegiatan->setRelation('siswas_list', $siswas);
        $kegiatan->load(['presensis']);
        
        return view('staff.pelatih.presensi', compact('kegiatan', 'siswas'));
    }

    public function storePresensi(Request $request, Kegiatan $kegiatan): RedirectResponse
    {
        if ($kegiatan->ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $request->validate([
            'presensi' => ['required', 'array'],
            'presensi.*' => ['required', 'in:hadir,izin,sakit,alfa'],
            'materi' => ['required', 'string'],
            'catatan' => ['nullable', 'string'],
            'foto_kegiatan' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Save Journal
        $data = $request->only(['materi', 'catatan']);
        if ($request->hasFile('foto_kegiatan')) {
            if ($kegiatan->foto_kegiatan) {
                Storage::disk('public')->delete($kegiatan->foto_kegiatan);
            }
            $data['foto_kegiatan'] = $request->file('foto_kegiatan')->store('jurnal', 'public');
        }
        $kegiatan->update($data);

        // Save Presensi
        foreach ($request->presensi as $siswaId => $status) {
            Presensi::updateOrCreate(
                ['kegiatan_id' => $kegiatan->id, 'siswa_id' => $siswaId],
                ['status' => $status]
            );
        }

        return redirect()->route('pelatih.ekskul.show', $kegiatan->ekskul_id)
            ->with('success', 'Kehadiran dan Jurnal berhasil dicatat.');
    }

    public function scan(Kegiatan $kegiatan): View
    {
        if ($kegiatan->ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        return view('staff.pelatih.scan', compact('kegiatan'));
    }

    public function processScan(Request $request, Kegiatan $kegiatan)
    {
        if ($kegiatan->ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $siswa = Siswa::where('nis', $request->nis)->first();

        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan'], 404);
        }

        // Check if student is enrolled in this ekskul
        if (!$kegiatan->ekskul->siswas()->where('siswa_id', $siswa->id)->exists()) {
             return response()->json(['success' => false, 'message' => 'Siswa tidak terdaftar di ekskul ini'], 400);
        }

        Presensi::updateOrCreate(
            ['kegiatan_id' => $kegiatan->id, 'siswa_id' => $siswa->id],
            ['status' => 'hadir']
        );

        return response()->json([
            'success' => true, 
            'message' => 'Kehadiran ' . $siswa->nama . ' berhasil dicatat',
            'siswa' => $siswa->nama
        ]);
    }

    public function storePrestasi(Request $request, Ekskul $ekskul): RedirectResponse
    {
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'sertifikat' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
        ]);

        $data = $request->only(['siswa_id', 'judul', 'deskripsi', 'tanggal']);
        $data['ekskul_id'] = $ekskul->id;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('prestasi/foto', 'public');
        }

        if ($request->hasFile('sertifikat')) {
            $data['sertifikat'] = $request->file('sertifikat')->store('prestasi/sertifikat', 'public');
        }

        Prestasi::create($data);

        return back()->with('success', 'Catatan prestasi berhasil ditambahkan.');
    }

    public function penilaian(Ekskul $ekskul): View
    {
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        // Load siswas and their corresponding penilaian for this ekskul
        $ekskul->load(['siswas.penilaians' => function ($query) use ($ekskul) {
            $query->where('ekskul_id', $ekskul->id);
        }]);

        return view('staff.pelatih.penilaian', compact('ekskul'));
    }

    public function storePenilaian(Request $request, Ekskul $ekskul): RedirectResponse
    {
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $request->validate([
            'penilaian' => ['required', 'array'],
            'penilaian.*.nilai' => ['required', 'string', 'max:5'],
            'penilaian.*.keterangan' => ['nullable', 'string'],
        ]);

        $pelatihId = Auth::guard('pelatih')->id();

        foreach ($request->penilaian as $siswaId => $data) {
            Penilaian::updateOrCreate(
                [
                    'ekskul_id' => $ekskul->id,
                    'siswa_id' => $siswaId,
                ],
                [
                    'pelatih_id' => $pelatihId,
                    'nilai' => $data['nilai'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()->route('pelatih.ekskul.show', $ekskul->id)
            ->with('success', 'Nilai peserta ekskul berhasil disimpan.');
    }
}
