<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffAuthController extends Controller
{
    /**
     * Show staff login form.
     */
    public function login(): View
    {
        return view('auth.staff-login');
    }

    /**
     * Authenticate staff (Pelatih or Pembina).
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:pelatih,pembina'],
        ]);

        $guard = $credentials['role'];
        unset($credentials['role']);

        if (Auth::guard($guard)->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route($guard . '.dashboard'));
        }

        return back()->withErrors([
            'nip' => 'NIP atau kata sandi salah untuk role ' . $guard,
        ])->onlyInput('nip', 'role');
    }

    /**
     * Logout staff.
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::guard('pelatih')->check()) {
            Auth::guard('pelatih')->logout();
        } elseif (Auth::guard('pembina')->check()) {
            Auth::guard('pembina')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
