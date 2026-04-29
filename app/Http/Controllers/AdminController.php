<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use App\Models\Siswa;
use App\Models\Pembina;
use App\Models\Pelatih;
use App\Models\User;
use App\Models\Prestasi;
use Illuminate\Support\Facades\DB;
use App\Imports\SiswaImport;
use App\Imports\StaffImport;
use App\Exports\SiswaTemplateExport;
use App\Exports\StaffTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Admin Dashboard.
     */
    public function dashboard(): View
    {
        $stats = [
            'siswa' => Siswa::count(),
            'pembina' => Pembina::count(),
            'pelatih' => Pelatih::count(),
            'ekskul' => Ekskul::count(),
        ];
        
        // Data Grafik
        $ekskulsData = Ekskul::withCount('siswas')->get();
        $chartLabels = $ekskulsData->pluck('nama')->toArray();
        $chartData = $ekskulsData->pluck('siswas_count')->toArray();

        // Data Prestasi
        $prestasis = Prestasi::with(['siswa', 'ekskul'])->latest('tanggal')->take(5)->get();

        // Rekap Presensi
        $attendanceRecap = DB::table('ekskuls')
            ->leftJoin('kegiatans', 'ekskuls.id', '=', 'kegiatans.ekskul_id')
            ->leftJoin('presensis', 'kegiatans.id', '=', 'presensis.kegiatan_id')
            ->select(
                'ekskuls.nama',
                DB::raw('COUNT(presensis.id) as total_presensi'),
                DB::raw('SUM(CASE WHEN presensis.status = "hadir" THEN 1 ELSE 0 END) as total_hadir')
            )
            ->groupBy('ekskuls.id', 'ekskuls.nama')
            ->get();
        
        return view('admin.dashboard', compact('stats', 'chartLabels', 'chartData', 'prestasis', 'attendanceRecap'));
    }

    /**
     * Manage Ekskuls.
     */
    public function ekskulIndex(): View
    {
        $ekskuls = Ekskul::with(['pembina', 'pelatih'])->get();
        $pembinas = Pembina::withCount('ekskuls')->get();
        $pelatihs = Pelatih::withCount('ekskuls')->get();
        
        return view('admin.ekskul.index', compact('ekskuls', 'pembinas', 'pelatihs'));
    }

    /**
     * Store new Ekskul.
     */
    public function ekskulStore(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:ekskuls,nama'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Ekskul::create($request->only(['nama', 'deskripsi']));

        return back()->with('success', 'Ekskul baru berhasil ditambahkan.');
    }

    /**
     * Delete Ekskul.
     */
    public function ekskulDestroy(Ekskul $ekskul): RedirectResponse
    {
        // Optional: Check if there are students joined
        if ($ekskul->siswas()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus ekskul yang masih memiliki anggota.');
        }

        $ekskul->delete();
        return back()->with('success', 'Ekskul berhasil dihapus.');
    }

    /**
     * Update Ekskul assignments.
     */
    public function ekskulUpdate(Request $request, Ekskul $ekskul): RedirectResponse
    {
        $request->validate([
            'pembina_id' => ['nullable', 'exists:pembinas,id'],
            'pelatih_id' => ['nullable', 'exists:pelatihs,id'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        // Check Pembina Limit (Max 3)
        if ($request->pembina_id && $request->pembina_id != $ekskul->pembina_id) {
            $pembina = Pembina::find($request->pembina_id);
            if ($pembina->ekskuls()->count() >= 3) {
                return back()->with('error', 'Pembina ' . $pembina->nama . ' sudah membina 3 ekskul (Maksimal).');
            }
        }

        // Check Pelatih Limit (Max 3)
        if ($request->pelatih_id && $request->pelatih_id != $ekskul->pelatih_id) {
            $pelatih = Pelatih::find($request->pelatih_id);
            if ($pelatih->ekskuls()->count() >= 3) {
                return back()->with('error', 'Pelatih ' . $pelatih->nama . ' sudah melatih 3 ekskul (Maksimal).');
            }
        }

        $ekskul->update($request->only(['pembina_id', 'pelatih_id', 'deskripsi']));

        return back()->with('success', 'Data ekskul berhasil diperbarui.');
    }

    /**
     * Manage Staff (Pembina & Pelatih).
     */
    public function staffIndex(): View
    {
        $pembinas = Pembina::withCount('ekskuls')->get();
        $pelatihs = Pelatih::withCount('ekskuls')->get();
        
        return view('admin.staff.index', compact('pembinas', 'pelatihs'));
    }

    /**
     * Manage Siswa.
     */
    public function siswaIndex(): View
    {
        $siswas = Siswa::withCount('ekskuls')->get();
        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Store new Staff (Pembina/Pelatih).
     */
    public function staffStore(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'unique:pembinas,nip', 'unique:pelatihs,nip'],
            'role' => ['required', 'in:pembina,pelatih'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $model = $request->role === 'pembina' ? Pembina::class : Pelatih::class;

        $model::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', ucfirst($request->role) . ' baru berhasil ditambahkan.');
    }

    /**
     * Store new Siswa.
     */
    public function siswaStore(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'unique:siswas,nis'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        Siswa::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    /**
     * Import Siswa from Excel.
     */
    public function siswaImport(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'mimes:xlsx,xls,csv'],
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return back()->with('success', 'Data siswa berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Download Siswa Template.
     */
    public function siswaTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template_siswa.xlsx');
    }

    /**
     * Import Staff from Excel.
     */
    public function staffImport(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'mimes:xlsx,xls,csv'],
        ]);

        try {
            Excel::import(new StaffImport, $request->file('file'));
            return back()->with('success', 'Data staf berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Download Staff Template.
     */
    public function staffTemplate()
    {
        return Excel::download(new StaffTemplateExport, 'template_staf.xlsx');
    }
}
