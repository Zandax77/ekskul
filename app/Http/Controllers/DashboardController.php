<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index(): View
    {
        $siswa = Auth::guard('siswa')->user();
        
        // Ekskul yang sudah diikuti (dengan relasi pembina dan penilaian)
        $ekskulsJoined = $siswa->ekskuls()->with(['pembina', 'penilaians' => function($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        }])->get();
        
        // Ekskul yang belum diikuti (dengan relasi pembina)
        $ekskulsAvailable = Ekskul::with('pembina')
            ->whereNotIn('id', $ekskulsJoined->pluck('id'))
            ->get();

        // Prestasi
        $prestasis = $siswa->prestasis()->with('ekskul')->latest()->get();

        return view('dashboard', compact('ekskulsJoined', 'ekskulsAvailable', 'prestasis'));
    }

    /**
     * Join an extracurricular.
     */
    public function join(Ekskul $ekskul): RedirectResponse
    {
        $siswa = Auth::guard('siswa')->user();
        
        if ($siswa->ekskuls()->where('ekskul_id', $ekskul->id)->exists()) {
            return back()->with('error', 'Anda sudah bergabung dengan ekskul ini.');
        }

        $siswa->ekskuls()->attach($ekskul->id);

        return back()->with('success', 'Berhasil bergabung dengan ekskul ' . $ekskul->nama . '!');
    }

    /**
     * Leave an extracurricular.
     */
    public function leave(Ekskul $ekskul): RedirectResponse
    {
        $siswa = Auth::guard('siswa')->user();
        
        $siswa->ekskuls()->detach($ekskul->id);
        
        return back()->with('success', 'Berhasil keluar dari ekskul ' . $ekskul->nama);
    }
}
