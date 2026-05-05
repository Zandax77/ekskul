<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Penilaian;

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

        return view('wali_kelas.dashboard', compact('siswas', 'waliKelas'));
    }
}
