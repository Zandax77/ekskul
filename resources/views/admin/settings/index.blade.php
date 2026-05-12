@extends('layouts.app')

@section('title', 'Pengaturan Sekolah - Admin')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    @include('admin.partials.nav')

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-white">Pengaturan Sekolah</h1>
            <p class="text-slate-400 mt-2">Atur identitas sekolah yang akan muncul di seluruh sistem.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm flex items-center gap-3">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-8 backdrop-blur-xl">
            <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Logo Sekolah -->
                <div class="space-y-4">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Logo Sekolah</label>
                    <div class="flex items-center gap-8">
                        <div class="h-32 w-32 rounded-3xl bg-white/5 border-2 border-dashed border-white/10 flex items-center justify-center overflow-hidden group relative">
                            @if($settings['logo_sekolah'])
                                <img src="{{ asset('storage/' . $settings['logo_sekolah']) }}" alt="Logo" class="h-full w-full object-contain p-2">
                            @else
                                <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 space-y-2">
                            <input type="file" name="logo_sekolah" id="logo_sekolah" class="hidden" accept="image/*">
                            <label for="logo_sekolah" class="inline-flex px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold rounded-lg cursor-pointer transition-colors border border-white/10">
                                Pilih File Logo
                            </label>
                            <p class="text-[10px] text-slate-500">Format: PNG, JPG, JPEG, SVG. Maksimal 2MB.</p>
                            @error('logo_sekolah')
                                <p class="text-[10px] text-red-400 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-white/5">

                <!-- Nama Sekolah -->
                <div class="space-y-2">
                    <label for="nama_sekolah" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" id="nama_sekolah" value="{{ old('nama_sekolah', $settings['nama_sekolah']) }}" required placeholder="Contoh: SMA Negeri 1 Antigravity" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-sm text-white outline-none focus:border-blue-500 transition-colors">
                    @error('nama_sekolah')
                        <p class="text-[10px] text-red-400 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Sekolah -->
                <div class="space-y-2">
                    <label for="alamat_sekolah" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Sekolah</label>
                    <textarea name="alamat_sekolah" id="alamat_sekolah" rows="3" placeholder="Jl. Angkasa No. 123, Kota Galaksi" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-sm text-white outline-none focus:border-blue-500 transition-colors">{{ old('alamat_sekolah', $settings['alamat_sekolah']) }}</textarea>
                    @error('alamat_sekolah')
                        <p class="text-[10px] text-red-400 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(37,99,235,0.2)]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
