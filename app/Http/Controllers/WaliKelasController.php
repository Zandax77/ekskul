<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Penilaian;
use App\Models\Presensi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WaliKelasController extends Controller
{
    public function showLogin()
    {
        return view('wali_kelas.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('wali_kelas')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('wali_kelas.dashboard'));
        }

        return back()->withErrors([
            'nip' => 'NIP atau kata sandi salah.',
        ])->onlyInput('nip');
    }

    public function logout(Request $request)
    {
        Auth::guard('wali_kelas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $waliKelas = Auth::guard('wali_kelas')->user();
        
        // Fetch students in the same class who follow at least one extracurricular
        $siswas = Siswa::where('kelas', $waliKelas->kelas)
            ->has('ekskuls')
            ->with(['penilaians.ekskul', 'penilaians.pelatih'])
            ->withCount('penilaians')
            ->get();

        // Monthly attendance for the whole class
        $monthlyAttendance = DB::table('presensis')
            ->join('kegiatans', 'presensis.kegiatan_id', '=', 'kegiatans.id')
            ->join('siswas', 'presensis.siswa_id', '=', 'siswas.id')
            ->where('siswas.kelas', $waliKelas->kelas)
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

        // Individual absence history for students in this class
        $absenceHistory = Presensi::join('kegiatans', 'presensis.kegiatan_id', '=', 'kegiatans.id')
            ->join('ekskuls', 'kegiatans.ekskul_id', '=', 'ekskuls.id')
            ->join('siswas', 'presensis.siswa_id', '=', 'siswas.id')
            ->where('siswas.kelas', $waliKelas->kelas)
            ->whereIn('presensis.status', ['alfa', 'izin', 'sakit'])
            ->select('presensis.*', 'kegiatans.tanggal', 'ekskuls.nama as ekskul_nama')
            ->orderBy('kegiatans.tanggal', 'desc')
            ->with('siswa')
            ->get();

        return view('wali_kelas.dashboard', compact('siswas', 'waliKelas', 'monthlyAttendance', 'absenceHistory'));
    }
}
