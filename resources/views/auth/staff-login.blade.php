@extends('layouts.guest')

@section('title', 'Staff Login - ' . config('app.name', 'Ekskul'))

@section('content')
<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 px-4 py-12 sm:px-6 lg:px-8">
    <div class="absolute -top-[10%] -left-[10%] h-[40%] w-[40%] rounded-full bg-blue-600/20 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] h-[40%] w-[40%] rounded-full bg-indigo-600/20 blur-[120px]"></div>

    <div class="relative w-full max-w-md space-y-8">
        <div class="text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-tr from-slate-600 to-slate-800 shadow-lg shadow-black/20 ring-1 ring-white/20">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-white">Staff Access</h2>
            <p class="mt-2 text-sm text-slate-400">Pintu masuk khusus Pelatih & Pembina</p>
        </div>

        <div class="mt-8 overflow-hidden rounded-3xl border border-white/10 bg-slate-900/50 backdrop-blur-xl shadow-2xl">
            <form action="{{ route('staff.login') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="role" class="block text-sm font-medium text-slate-300">Masuk Sebagai</label>
                        <select id="role" name="role" required 
                            class="mt-1.5 block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 px-4 text-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 sm:text-sm outline-none transition-all duration-200">
                            <option value="pelatih">Pelatih (Coach)</option>
                            <option value="pembina">Pembina (Supervisor)</option>
                            <option value="wali_kelas">Wali Kelas (Homeroom Teacher)</option>
                        </select>
                    </div>

                    <div>
                        <label for="nip" class="block text-sm font-medium text-slate-300">NIP</label>
                        <div class="mt-1.5 relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <input id="nip" name="nip" type="text" required 
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 pl-10 pr-3 text-slate-200 placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 sm:text-sm transition-all duration-200 outline-none"
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
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 pl-10 pr-3 text-slate-200 placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 sm:text-sm transition-all duration-200 outline-none"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                        class="h-4 w-4 rounded border-white/10 bg-slate-800/50 text-blue-600 focus:ring-blue-500/20 focus:ring-offset-slate-900">
                    <label for="remember" class="ml-2 block text-sm text-slate-400">Ingat saya</label>
                </div>

                <div>
                    <button type="submit" 
                        class="group relative flex w-full justify-center rounded-xl bg-gradient-to-tr from-slate-600 to-slate-800 py-3 px-4 text-sm font-semibold text-white hover:from-slate-500 hover:to-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500/50 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 shadow-lg shadow-black/20 active:scale-[0.98]">
                        Masuk Sekarang
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-blue-400 transition-colors">Masuk sebagai Siswa</a>
        </div>
    </div>
</div>
@endsection
