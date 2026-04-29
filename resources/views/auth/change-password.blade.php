@extends('layouts.guest')

@section('title', 'Ganti Sandi - ' . config('app.name', 'Ekskul'))

@section('content')
<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 px-4 py-12 sm:px-6 lg:px-8">
    <!-- Decorative Background Elements -->
    <div class="absolute -top-[10%] -left-[10%] h-[40%] w-[40%] rounded-full bg-blue-600/20 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] h-[40%] w-[40%] rounded-full bg-indigo-600/20 blur-[120px]"></div>

    <div class="relative w-full max-w-md space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-white">Ganti Kata Sandi</h2>
            <p class="mt-2 text-sm text-slate-400">Pastikan kata sandi baru Anda kuat dan unik</p>
        </div>

        <!-- Change Password Card -->
        <div class="mt-8 overflow-hidden rounded-3xl border border-white/10 bg-slate-900/50 backdrop-blur-xl shadow-2xl">
            <form action="{{ route('password.update') }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('put')

                @if (session('status') === 'password-updated')
                    <div class="rounded-xl bg-emerald-500/10 p-4 border border-emerald-500/20">
                        <p class="text-sm text-emerald-400">Kata sandi berhasil diperbarui.</p>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-300">Kata Sandi Saat Ini</label>
                        <div class="mt-1.5 relative">
                            <input id="current_password" name="current_password" type="password" required 
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 px-4 text-slate-200 placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 sm:text-sm transition-all duration-200 outline-none">
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300">Kata Sandi Baru</label>
                        <div class="mt-1.5 relative">
                            <input id="password" name="password" type="password" required 
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 px-4 text-slate-200 placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 sm:text-sm transition-all duration-200 outline-none">
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300">Konfirmasi Kata Sandi Baru</label>
                        <div class="mt-1.5 relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="block w-full rounded-xl border border-white/10 bg-slate-800/50 py-3 px-4 text-slate-200 placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 sm:text-sm transition-all duration-200 outline-none">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('dashboard') }}" 
                        class="order-2 sm:order-1 flex-1 flex justify-center rounded-xl border border-white/10 bg-slate-800/50 py-3 px-4 text-sm font-semibold text-slate-300 hover:bg-slate-800 transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                        class="order-1 sm:order-2 flex-[2] flex justify-center rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 py-3 px-4 text-sm font-semibold text-white hover:from-blue-500 hover:to-indigo-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 shadow-lg shadow-blue-600/20 active:scale-[0.98]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
