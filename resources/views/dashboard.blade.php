@extends('layouts.app')

@section('title', 'Dashboard Siswa - ' . config('app.name', 'Ekskul'))

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <!-- Navbar -->
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">EkskulHub</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden sm:block text-right mr-2 md:mr-4">
                        <p class="text-sm font-medium text-white">{{ Auth::guard('siswa')->user()->nama }}</p>
                        <p class="text-xs text-slate-500">NIS: {{ Auth::guard('siswa')->user()->nis }}</p>
                    </div>
                    <div class="relative group">
                        <button class="flex items-center gap-2 p-1 rounded-full hover:bg-white/5 transition-colors">
                            <div class="h-8 w-8 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center text-blue-400 font-bold">
                                {{ substr(Auth::guard('siswa')->user()->nama, 0, 1) }}
                            </div>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 rounded-xl border border-white/10 bg-slate-900 shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="p-2 space-y-1">
                                <a href="{{ route('password.edit') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 rounded-lg transition-colors">Ganti Sandi</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-400/5 rounded-lg transition-colors">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-500/10 p-4 border border-emerald-500/20 flex items-center gap-3">
                <svg class="h-5 w-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm text-emerald-400">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl bg-red-500/10 p-4 border border-red-500/20 flex items-center gap-3">
                <svg class="h-5 w-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Welcome Hero -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-tr from-blue-600 to-indigo-700 p-8 mb-10 shadow-2xl shadow-blue-900/20">
            <div class="relative z-10 md:flex items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2 text-center md:text-left">Halo, {{ explode(' ', Auth::guard('siswa')->user()->nama)[0] }}! 👋</h1>
                    <p class="text-blue-100 text-base md:text-lg text-center md:text-left">Semangat beraktivitas di kegiatan ekstrakurikuler hari ini.</p>
                </div>
                <div class="mt-6 md:mt-0 flex justify-center gap-3 md:gap-4">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 md:p-4 text-center min-w-[80px] md:min-w-[100px]">
                        <p class="text-xl md:text-2xl font-bold text-white">{{ $ekskulsJoined->count() }}</p>
                        <p class="text-[10px] md:text-xs text-blue-100 uppercase tracking-wider">Ekskul Saya</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 md:p-4 text-center min-w-[80px] md:min-w-[100px]">
                        <p class="text-xl md:text-2xl font-bold text-white">{{ $ekskulsAvailable->count() }}</p>
                        <p class="text-[10px] md:text-xs text-blue-100 uppercase tracking-wider">Tersedia</p>
                    </div>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Joined Ekskul -->
            <div class="lg:col-span-2 space-y-8">
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                            Ekskul yang Saya Ikuti
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($ekskulsJoined as $ekskul)
                            <div class="group bg-slate-900/50 border border-white/10 rounded-2xl p-5 hover:border-blue-500/50 transition-all duration-300">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-white">{{ $ekskul->nama }}</h3>
                                        <p class="text-sm text-slate-400">{{ $ekskul->pembina->nama ?? '-' }}</p>
                                    </div>
                                    <div class="bg-blue-500/10 text-blue-400 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Terdaftar</div>
                                </div>
                                <div class="space-y-4 mb-6">
                                    <div class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $ekskul->jadwal }}
                                    </div>
                                    
                                    @php
                                        $penilaian = $ekskul->penilaians->first();
                                    @endphp
                                    @if($penilaian)
                                        <div class="p-3 bg-indigo-500/10 border border-indigo-500/20 rounded-xl">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider">Nilai Akhir</span>
                                                <span class="text-lg font-black text-white">{{ $penilaian->nilai }}</span>
                                            </div>
                                            @if($penilaian->keterangan)
                                                <p class="text-xs text-slate-400 italic mt-1 border-t border-indigo-500/10 pt-2">"{{ $penilaian->keterangan }}"</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <form action="{{ route('ekskul.leave', $ekskul) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Yakin ingin keluar dari ekskul ini?')" class="text-sm font-medium text-slate-500 hover:text-red-400 transition-colors">Berhenti Mengikuti</button>
                                </form>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 bg-slate-900/30 border border-dashed border-white/10 rounded-3xl p-8 md:p-12 text-center">
                                <div class="mx-auto h-12 w-12 text-slate-600 mb-4 flex items-center justify-center">
                                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-slate-400">Anda belum mengikuti ekstrakurikuler apapun.</p>
                                <p class="text-sm text-slate-600 mt-1">Silakan pilih ekskul yang tersedia di samping.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section>
                    <div class="flex items-center justify-between mb-6 pt-4">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Catatan Prestasi Saya
                        </h2>
                    </div>

                    <div class="space-y-4">
                        @forelse($prestasis as $p)
                            <div class="bg-slate-900/50 border border-white/10 rounded-2xl p-6 transition-all hover:bg-slate-900">
                                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                                    <div class="flex-grow">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded uppercase tracking-wider">{{ $p->ekskul->nama }}</span>
                                            <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y') }}</span>
                                        </div>
                                        <h3 class="text-lg font-bold text-white mb-1">{{ $p->judul }}</h3>
                                        <p class="text-sm text-slate-400">{{ $p->deskripsi }}</p>
                                    </div>
                                    <div class="flex gap-2 shrink-0">
                                        @if($p->foto)
                                            <a href="{{ Storage::url($p->foto) }}" target="_blank" class="p-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-slate-400 hover:text-white transition-all flex items-center gap-2 text-xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                Foto
                                            </a>
                                        @endif
                                        @if($p->sertifikat)
                                            <a href="{{ Storage::url($p->sertifikat) }}" target="_blank" class="p-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-slate-400 hover:text-white transition-all flex items-center gap-2 text-xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                Sertifikat
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-slate-900/30 border border-dashed border-white/10 rounded-3xl p-8 text-center">
                                <p class="text-slate-500 text-sm">Belum ada catatan prestasi yang terdaftar.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section>
                    <div class="flex items-center justify-between mb-6 pt-4">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                            Jelajahi Ekskul Baru
                        </h2>
                        @if($ekskulsAvailable->count() > 0)
                            <span class="text-xs text-slate-500 bg-white/5 px-3 py-1 rounded-full">
                                {{ $ekskulsAvailable->count() }} ekskul tersedia
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($ekskulsAvailable as $ekskul)
                            <div class="group bg-slate-900/50 border border-white/5 rounded-2xl p-5 hover:border-indigo-500/40 hover:bg-slate-900 transition-all duration-300 flex flex-col justify-between">
                                <div>
                                    {{-- Header kartu --}}
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0 group-hover:bg-indigo-500/20 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                            Terbuka
                                        </span>
                                    </div>

                                    <h3 class="text-base font-bold text-white mb-1">{{ $ekskul->nama }}</h3>
                                    <p class="text-xs text-slate-500 mb-3">Pembina: {{ $ekskul->pembina->nama ?? '-' }}</p>

                                    @if($ekskul->deskripsi)
                                        <p class="text-sm text-slate-400 mb-4 line-clamp-2 leading-relaxed">{{ $ekskul->deskripsi }}</p>
                                    @endif

                                    {{-- Jadwal --}}
                                    <div class="flex items-center gap-2 bg-white/5 rounded-lg px-3 py-2 text-xs text-slate-300 mb-5 w-fit">
                                        <svg class="h-3.5 w-3.5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $ekskul->jadwal }}
                                    </div>
                                </div>

                                {{-- Tombol Gabung --}}
                                <form action="{{ route('ekskul.join', $ekskul) }}" method="POST" class="join-form">
                                    @csrf
                                    <input type="hidden" name="ekskul_nama" value="{{ e($ekskul->nama) }}">
                                    <button type="submit"
                                        class="join-btn w-full py-2.5 rounded-xl bg-indigo-600/20 border border-indigo-500/30 text-sm font-semibold text-indigo-300 hover:bg-indigo-600 hover:text-white hover:border-indigo-500 transition-all duration-300 group-hover:shadow-[0_0_20px_rgba(99,102,241,0.15)]">
                                        Gabung Sekarang →
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 bg-slate-900/30 border border-dashed border-white/10 rounded-3xl p-10 text-center">
                                <div class="mx-auto h-12 w-12 text-slate-700 mb-4 flex items-center justify-center">
                                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-medium">Anda sudah bergabung di semua ekskul!</p>
                                <p class="text-sm text-slate-600 mt-1">Tidak ada ekskul lain yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Sidebar / Info -->
            <div class="space-y-6">
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Informasi Siswa</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 p-3 bg-white/5 rounded-2xl">
                            <div class="h-10 w-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider">Nama Lengkap</p>
                                <p class="text-sm font-medium text-white">{{ Auth::guard('siswa')->user()->nama }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-white/5 rounded-2xl">
                            <div class="h-10 w-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider">NIS</p>
                                <p class="text-sm font-medium text-white">{{ Auth::guard('siswa')->user()->nis }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-white/10 space-y-3">
                        <a href="{{ route('password.edit') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-colors group">
                            <span class="text-sm text-slate-300">Ganti Kata Sandi</span>
                            <svg class="h-4 w-4 text-slate-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-slate-950 border border-white/10 rounded-3xl p-6 relative overflow-hidden">
                    <h3 class="text-lg font-bold text-white mb-2 relative z-10">Bantuan</h3>
                    <p class="text-sm text-slate-400 relative z-10 mb-4">Butuh bantuan terkait pendaftaran ekskul atau masalah teknis lainnya?</p>
                    <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-blue-400 hover:text-blue-300 relative z-10 transition-colors">
                        Hubungi Admin
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    <div class="absolute -right-8 -bottom-8 h-24 w-24 rounded-full bg-blue-500/10 blur-2xl"></div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
