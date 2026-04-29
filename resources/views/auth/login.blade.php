@extends('layouts.guest')

@section('title', 'Login - ' . config('app.name', 'Ekskul'))

@section('content')
<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 px-4 py-12 sm:px-6 lg:px-8">
    <!-- Decorative Background Elements -->
    <div class="absolute -top-[10%] -left-[10%] h-[40%] w-[40%] rounded-full bg-blue-600/20 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] h-[40%] w-[40%] rounded-full bg-indigo-600/20 blur-[120px]"></div>

    <div class="relative w-full max-w-md space-y-8">
        <!-- Logo/Header -->
        <div class="text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/20 ring-1 ring-white/20">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-white">Selamat Datang</h2>
            <p class="mt-2 text-sm text-slate-400">Silakan masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <!-- Login Card -->
        <div class="mt-8 overflow-hidden rounded-3xl border border-white/10 bg-slate-900/50 backdrop-blur-xl shadow-2xl">
            <form action="{{ route('login') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nis" class="block text-sm font-medium text-slate-300">NIS (Nomor Induk Siswa)</label>
                        <div class="mt-1.5 relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <input id="nis" name="nis" type="text" autocomplete="username" required 
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 pl-10 pr-3 text-slate-200 placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 sm:text-sm transition-all duration-200 outline-none"
                                placeholder="Masukkan NIS Anda">
                        </div>
                        @error('nis')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-slate-300">Kata Sandi</label>
                        </div>
                        <div class="mt-1.5 relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 pl-10 pr-3 text-slate-200 placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 sm:text-sm transition-all duration-200 outline-none"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" 
                        class="h-4 w-4 rounded border-white/10 bg-slate-800/50 text-blue-600 focus:ring-blue-500/20 focus:ring-offset-slate-900">
                    <label for="remember-me" class="ml-2 block text-sm text-slate-400">Ingat saya</label>
                </div>

                <div>
                    <button type="submit" 
                        class="group relative flex w-full justify-center rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 py-3 px-4 text-sm font-semibold text-white hover:from-blue-500 hover:to-indigo-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 shadow-lg shadow-blue-600/20 active:scale-[0.98]">
                        Masuk Sekarang
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-sm text-slate-500">
            Masalah login? Hubungi Admin Sekolah
        </p>
        
        <div class="text-center">
            <a href="{{ route('admin.login') }}" class="text-xs text-slate-600 hover:text-red-400 transition-colors">Masuk sebagai Admin</a>
        </div>
    </div>
</div>
@endsection
