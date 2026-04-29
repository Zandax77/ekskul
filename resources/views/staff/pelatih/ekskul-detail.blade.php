@extends('layouts.app')

@section('title', 'Kelola Ekskul - ' . $ekskul->nama)

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-4">
                    <a href="{{ route('pelatih.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-xl font-bold text-white">{{ $ekskul->nama }}</h1>
                </div>
                <div>
                    <a href="{{ route('pelatih.penilaian', $ekskul->id) }}" class="px-4 py-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600/30 text-sm font-bold rounded-xl transition-all border border-blue-500/30">
                        Kelola Nilai Akhir
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-500/10 p-4 border border-emerald-500/20 text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Achievement List Section -->
                <div class="space-y-6">
                    <h2 class="text-lg font-bold text-white">Catatan Prestasi Siswa</h2>
                    <div class="space-y-4">
                        @forelse($ekskul->prestasis->sortByDesc('tanggal') as $p)
                            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 transition-all hover:border-blue-500/30">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <div class="flex-grow">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded uppercase tracking-wider">PRESTASI</span>
                                            <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y') }}</span>
                                        </div>
                                        <h4 class="text-lg font-bold text-white mb-1">{{ $p->judul }}</h4>
                                        <p class="text-sm text-slate-400 mb-4">{{ $p->deskripsi }}</p>
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-[10px] font-bold text-blue-400 border border-white/5">
                                                {{ strtoupper(substr($p->siswa->nama, 0, 2)) }}
                                            </div>
                                            <div class="text-xs">
                                                <p class="text-slate-300 font-medium">{{ $p->siswa->nama }}</p>
                                                <p class="text-slate-500">{{ $p->siswa->nis }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-2 shrink-0">
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
                            <div class="text-center py-12 bg-slate-900/30 rounded-3xl border border-dashed border-white/10">
                                <p class="text-slate-500 text-sm">Belum ada prestasi yang dicatat.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-6 pt-8 border-t border-white/5">
                    <h2 class="text-lg font-bold text-white">Riwayat / Jadwal Latihan</h2>
                    <div class="space-y-4">
                        @forelse($ekskul->kegiatans->sortByDesc('tanggal') as $kegiatan)
                            <div class="bg-slate-900/50 border border-white/10 rounded-2xl p-5 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold text-white">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $kegiatan->keterangan ?? 'Latihan Rutin' }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-slate-400">{{ $kegiatan->presensis->count() }} / {{ $ekskul->siswas->count() }} Hadir</span>
                                    <a href="{{ route('pelatih.presensi', $kegiatan) }}" class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-xs font-bold text-white hover:bg-white/10 transition-colors">
                                        Catat Kehadiran
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-slate-900/30 rounded-3xl border border-dashed border-white/10">
                                <p class="text-slate-500 text-sm">Belum ada jadwal latihan yang dibuat.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Add Achievement Form -->
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Catat Prestasi Baru</h3>
                    <form action="{{ route('pelatih.prestasi.store', $ekskul) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1.5">Siswa</label>
                            <select name="siswa_id" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none">
                                <option value="">Pilih Siswa</option>
                                @foreach($ekskul->siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->nis }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1.5">Judul Prestasi</label>
                            <input type="text" name="judul" required placeholder="Contoh: Juara 1 Lomba Basket Nasional" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" required rows="3" placeholder="Jelaskan detail prestasi..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none resize-none"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1.5">Tanggal</label>
                                <input type="date" name="tanggal" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1.5">Bukti Foto</label>
                                <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1.5">File Sertifikat (PDF/Gambar)</label>
                            <input type="file" name="sertifikat" accept=".pdf,image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                        </div>
                        <button type="submit" class="w-full py-3 rounded-xl bg-blue-600 text-sm font-bold text-white hover:bg-blue-500 transition-colors">
                            Simpan Prestasi
                        </button>
                    </form>
                </div>

                <!-- Add Activity Form -->
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Tambah Jadwal Latihan</h3>
                    <form action="{{ route('pelatih.kegiatan.store', $ekskul) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1.5">Tanggal Latihan</label>
                            <input type="date" name="tanggal" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1.5">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" placeholder="Contoh: Latihan Fisik" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none">
                        </div>
                        <button type="submit" class="w-full py-3 rounded-xl bg-white/5 border border-white/10 text-sm font-bold text-white hover:bg-white/10 transition-colors">
                            Buat Jadwal Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
