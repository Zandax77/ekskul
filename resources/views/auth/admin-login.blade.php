@extends('layouts.guest')

@section('title', 'Admin Login - ' . config('app.name', 'Ekskul'))

@section('content')
<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 px-4 py-12 sm:px-6 lg:px-8">
    <div class="absolute -top-[10%] -left-[10%] h-[40%] w-[40%] rounded-full bg-red-600/20 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] h-[40%] w-[40%] rounded-full bg-slate-600/20 blur-[120px]"></div>

    <div class="relative w-full max-w-md space-y-8">
        <div class="text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-tr from-slate-700 to-slate-900 shadow-lg shadow-black/20 ring-1 ring-white/20">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-white">Admin Central</h2>
            <p class="mt-2 text-sm text-slate-400">Masuk sebagai Pengelola Utama</p>
        </div>

        <div class="mt-8 overflow-hidden rounded-3xl border border-white/10 bg-slate-900/50 backdrop-blur-xl shadow-2xl">
            <form action="{{ route('admin.login') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300">Email Admin</label>
                        <div class="mt-1.5 relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" required 
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 pl-10 pr-3 text-slate-200 placeholder-slate-500 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 sm:text-sm transition-all duration-200 outline-none"
                                placeholder="admin@ekskul.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300">Kata Sandi</label>
                        <div class="mt-1.5 relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 pl-10 pr-3 text-slate-200 placeholder-slate-500 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 sm:text-sm transition-all duration-200 outline-none"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                        class="h-4 w-4 rounded border-white/10 bg-slate-800/50 text-red-600 focus:ring-red-500/20 focus:ring-offset-slate-900">
                    <label for="remember" class="ml-2 block text-sm text-slate-400">Ingat sesi ini</label>
                </div>

                <div>
                    <button type="submit" 
                        class="group relative flex w-full justify-center rounded-xl bg-gradient-to-tr from-slate-700 to-slate-900 py-3 px-4 text-sm font-semibold text-white hover:from-slate-600 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 shadow-lg shadow-black/20 active:scale-[0.98]">
                        Masuk Admin
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-blue-400 transition-colors">Bukan Admin? Masuk sebagai Siswa</a>
        </div>
    </div>
</div>
@endsection
