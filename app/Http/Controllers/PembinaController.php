<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Prestasi;
use App\Models\Presensi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Siswa;

class PembinaController extends Controller
{
    public function index(): View
    {
        $pembina = Auth::guard('pembina')->user();
        $ekskuls = $pembina->ekskuls;
        
        return view('staff.pembina.dashboard', compact('ekskuls'));
    }

    public function show(Ekskul $ekskul): View
    {
        if ($ekskul->pembina_id !== Auth::guard('pembina')->id()) {
            abort(403);
        }

        $ekskul->load(['kegiatans.presensis.siswa', 'siswas', 'prestasis.siswa']);
        
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
            
        return view('staff.pembina.report', compact('ekskul', 'monthlyAttendance', 'absenteeRecap', 'absenteeDistribution', 'siswas'));
    }

    /**
     * Export attendance to PDF.
     */
    public function exportPDF(Ekskul $ekskul)
    {
        if ($ekskul->pembina_id !== Auth::guard('pembina')->id()) {
            abort(403);
        }

        $ekskul->load(['pembina', 'pelatih', 'siswas']);
        $totalSesi = $ekskul->kegiatans()->count();

        $reportData = $ekskul->siswas->map(function ($siswa) use ($ekskul, $totalSesi) {
            $hadir = $ekskul->presensis()
                ->where('siswa_id', $siswa->id)
                ->where('status', 'hadir')
                ->count();

            return [
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'hadir' => $hadir,
                'total_sesi' => $totalSesi,
                'persentase' => $totalSesi > 0 ? round(($hadir / $totalSesi) * 100, 1) : 0,
            ];
        });

        $pdf = Pdf::loadView('reports.attendance', compact('ekskul', 'reportData'));
        
        return $pdf->download('laporan_presensi_' . strtolower(str_replace(' ', '_', $ekskul->nama)) . '.pdf');
    }

    public function storePrestasi(Request $request, Ekskul $ekskul): RedirectResponse
    {
        if ($ekskul->pembina_id !== Auth::guard('pembina')->id()) {
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
}
