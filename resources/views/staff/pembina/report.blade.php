@extends('layouts.app')

@section('title', 'Laporan Kehadiran - ' . $ekskul->nama)

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 w-full">
                <div class="flex items-center gap-4">
                    <a href="{{ route('pembina.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-xl font-bold text-white">Laporan: {{ $ekskul->nama }}</h1>
                </div>
                
                <a href="{{ route('pembina.report.pdf', $ekskul) }}" class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-red-600/20">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    PDF
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
        @if(session('success'))
            <div class="rounded-2xl bg-emerald-500/10 p-4 border border-emerald-500/20 text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">Laporan Kehadiran</h2>
            </div>
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/10">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Siswa</th>
                                @foreach($ekskul->kegiatans->sortBy('tanggal') as $kegiatan)
                                    <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-slate-400 text-center whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d/m') }}
                                    </th>
                                @endforeach
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Hadir %</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($ekskul->siswas as $siswa)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-white">{{ $siswa->nama }}</p>
                                        <p class="text-[10px] text-slate-500">NIS: {{ $siswa->nis }}</p>
                                    </td>
                                    @php $hadirCount = 0; $totalKegiatan = $ekskul->kegiatans->count(); @endphp
                                    @foreach($ekskul->kegiatans->sortBy('tanggal') as $kegiatan)
                                        @php
                                            $pStatus = $kegiatan->presensis->where('siswa_id', $siswa->id)->first();
                                            if($pStatus && $pStatus->status == 'hadir') $hadirCount++;
                                        @endphp
                                        <td class="px-4 py-4 text-center">
                                            @if($pStatus)
                                                <span class="inline-block h-2 w-2 rounded-full {{ $pStatus->status == 'hadir' ? 'bg-emerald-500' : ($pStatus->status == 'alfa' ? 'bg-red-500' : 'bg-yellow-500') }}" title="{{ $pStatus->status }}"></span>
                                            @else
                                                <span class="text-slate-700">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm font-mono {{ $totalKegiatan > 0 ? ($hadirCount/$totalKegiatan > 0.8 ? 'text-emerald-400' : 'text-yellow-400') : 'text-slate-500' }}">
                                            {{ $totalKegiatan > 0 ? round(($hadirCount / $totalKegiatan) * 100) : 0 }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($ekskul->kegiatans->isEmpty())
                    <div class="py-12 text-center">
                        <p class="text-slate-500 text-sm">Belum ada data kehadiran untuk ditampilkan.</p>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex gap-6">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span class="text-xs text-slate-400">Hadir</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                    <span class="text-xs text-slate-400">Izin / Sakit</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                    <span class="text-xs text-slate-400">Alfa</span>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-8 border-t border-white/5">
            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-xl font-bold text-white">Catatan Prestasi Siswa</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($ekskul->prestasis->sortByDesc('tanggal') as $p)
                        <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[10px] font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded tracking-wider uppercase">PRESTASI</span>
                                    <span class="text-[10px] text-slate-500">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</span>
                                </div>
                                <h4 class="text-white font-bold mb-2">{{ $p->judul }}</h4>
                                <p class="text-slate-400 text-xs mb-4 line-clamp-2">{{ $p->deskripsi }}</p>
                                <div class="flex items-center gap-2 mb-6">
                                    <div class="w-6 h-6 rounded-full bg-slate-800 flex items-center justify-center text-[8px] font-bold text-blue-400">
                                        {{ strtoupper(substr($p->siswa->nama, 0, 2)) }}
                                    </div>
                                    <span class="text-xs text-slate-300">{{ $p->siswa->nama }}</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                @if($p->foto)
                                    <a href="{{ Storage::url($p->foto) }}" target="_blank" class="flex-grow py-2 text-center bg-white/5 border border-white/10 rounded-lg text-xs text-slate-400 hover:text-white transition-colors">Foto</a>
                                @endif
                                @if($p->sertifikat)
                                    <a href="{{ Storage::url($p->sertifikat) }}" target="_blank" class="flex-grow py-2 text-center bg-white/5 border border-white/10 rounded-lg text-xs text-slate-400 hover:text-white transition-colors">Sertifikat</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 py-12 text-center bg-slate-900/30 rounded-3xl border border-dashed border-white/10">
                            <p class="text-slate-500 text-sm">Belum ada catatan prestasi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-white mb-4">Catat Prestasi Baru</h3>
                    <form action="{{ route('pembina.prestasi.store', $ekskul) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Siswa</label>
                            <select name="siswa_id" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none">
                                <option value="">Pilih Siswa</option>
                                @foreach($ekskul->siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Judul Prestasi</label>
                            <input type="text" name="judul" required placeholder="Juara 1 Lomba..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" required rows="3" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                            <input type="date" name="tanggal" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:border-blue-500 outline-none">
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Foto</label>
                                <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-blue-600 file:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Sertifikat (PDF)</label>
                                <input type="file" name="sertifikat" accept=".pdf,image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-indigo-600 file:text-white">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-3 mt-4 rounded-xl bg-blue-600 text-sm font-bold text-white hover:bg-blue-500 transition-colors shadow-lg shadow-blue-600/20">
                            Simpan Prestasi
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection
