@extends('layouts.app')

@section('title', 'Catat Kehadiran - ' . $kegiatan->ekskul->nama)

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16 gap-4">
                <a href="{{ route('pelatih.ekskul.show', $kegiatan->ekskul_id) }}" class="text-slate-400 hover:text-white transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-white">Presensi: {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}</h1>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-white/10">
                <h2 class="text-lg font-bold text-white">Daftar Anggota Ekskul</h2>
                <p class="text-sm text-slate-500">Silakan tandai kehadiran setiap siswa di bawah ini.</p>
            </div>

            <form action="{{ route('pelatih.presensi.store', $kegiatan) }}" method="POST">
                @csrf
                <div class="divide-y divide-white/5">
                    @foreach($kegiatan->ekskul->siswas as $siswa)
                        @php
                            $status = $kegiatan->presensis->where('siswa_id', $siswa->id)->first()?->status ?? 'hadir';
                        @endphp
                        <div class="p-4 flex items-center justify-between hover:bg-white/5 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center text-blue-400 font-bold">
                                    {{ substr($siswa->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">{{ $siswa->nama }}</p>
                                    <p class="text-xs text-slate-500">NIS: {{ $siswa->nis }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                @foreach(['hadir', 'izin', 'sakit', 'alfa'] as $s)
                                    <label class="relative flex items-center cursor-pointer">
                                        <input type="radio" name="presensi[{{ $siswa->id }}]" value="{{ $s }}" {{ $status == $s ? 'checked' : '' }} class="sr-only peer">
                                        <div class="px-3 py-1.5 rounded-lg border border-white/10 text-[10px] font-bold uppercase tracking-wider transition-all
                                            peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-500
                                            text-slate-500 hover:bg-white/5">
                                            {{ $s }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 bg-slate-900/80 border-t border-white/10">
                    <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-sm font-bold text-white shadow-lg shadow-blue-600/20 hover:from-blue-500 hover:to-indigo-500 transition-all">
                        Simpan Semua Data Kehadiran
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
