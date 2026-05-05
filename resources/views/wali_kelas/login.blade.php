@extends('layouts.guest')

@section('title', 'Login Wali Kelas - ' . config('app.name', 'Ekskul'))

@section('content')
<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 px-4 py-12 sm:px-6 lg:px-8">
    <div class="absolute -top-[10%] -left-[10%] h-[40%] w-[40%] rounded-full bg-emerald-600/20 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] h-[40%] w-[40%] rounded-full bg-teal-600/20 blur-[120px]"></div>

    <div class="relative w-full max-w-md space-y-8">
        <div class="text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-800 shadow-lg shadow-black/20 ring-1 ring-white/20">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-white">Wali Kelas Access</h2>
            <p class="mt-2 text-sm text-slate-400">Pintu masuk laporan rekap nilai kelas</p>
        </div>

        <div class="mt-8 overflow-hidden rounded-3xl border border-white/10 bg-slate-900/50 backdrop-blur-xl shadow-2xl">
            <form action="{{ route('wali_kelas.login') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nip" class="block text-sm font-medium text-slate-300">NIP</label>
                        <div class="mt-1.5 relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <input id="nip" name="nip" type="text" required value="{{ old('nip') }}"
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 pl-10 pr-3 text-slate-200 placeholder-slate-500 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 sm:text-sm transition-all duration-200 outline-none"
                                placeholder="Masukkan NIP Anda">
                        </div>
                        @error('nip')
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
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 pl-10 pr-3 text-slate-200 placeholder-slate-500 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 sm:text-sm transition-all duration-200 outline-none"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                        class="h-4 w-4 rounded border-white/10 bg-slate-800/50 text-emerald-600 focus:ring-emerald-500/20 focus:ring-offset-slate-900">
                    <label for="remember" class="ml-2 block text-sm text-slate-400">Ingat saya</label>
                </div>

                <div>
                    <button type="submit" 
                        class="group relative flex w-full justify-center rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-800 py-3 px-4 text-sm font-semibold text-white hover:from-emerald-500 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 shadow-lg shadow-black/20 active:scale-[0.98]">
                        Masuk Sekarang
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center space-y-4">
            <a href="{{ route('staff.login') }}" class="block text-sm text-slate-500 hover:text-emerald-400 transition-colors">Masuk sebagai Staff (Pelatih/Pembina)</a>
            <a href="{{ route('login') }}" class="block text-sm text-slate-500 hover:text-blue-400 transition-colors">Masuk sebagai Siswa</a>
        </div>
    </div>
</div>
@endsection
