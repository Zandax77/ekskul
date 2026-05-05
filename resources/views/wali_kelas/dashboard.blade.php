@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas - ' . $waliKelas->kelas)

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 w-full">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-800 shadow-lg shadow-emerald-600/20">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Wali Kelas: {{ $waliKelas->nama }}</h1>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Kelas: {{ $waliKelas->kelas }}</p>
                    </div>
                </div>
                
                <form action="{{ route('wali_kelas.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white text-xs font-bold rounded-xl transition-all border border-white/10">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <header>
            <h2 class="text-2xl font-bold text-white mb-2">Rekap Nilai Peserta Ekskul</h2>
            <p class="text-slate-400 text-sm">Berikut adalah daftar nilai ekstrakurikuler siswa di kelas {{ $waliKelas->kelas }}.</p>
        </header>

        <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10">
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Siswa</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Ekstrakurikuler</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400 text-center">Nilai</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Keterangan / Feedback Pelatih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($siswas as $siswa)
                            @if($siswa->penilaians->isEmpty())
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-6">
                                        <p class="text-sm font-medium text-white">{{ $siswa->nama }}</p>
                                        <p class="text-[10px] text-slate-500">NIS: {{ $siswa->nis }}</p>
                                    </td>
                                    <td colspan="3" class="px-6 py-6 text-center text-slate-600 italic text-xs">
                                        Belum mengikuti ekstrakurikuler atau belum ada penilaian.
                                    </td>
                                </tr>
                            @else
                                @foreach($siswa->penilaians as $index => $penilaian)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        @if($index === 0)
                                            <td class="px-6 py-6 align-top" rowspan="{{ $siswa->penilaians->count() }}">
                                                <p class="text-sm font-medium text-white">{{ $siswa->nama }}</p>
                                                <p class="text-[10px] text-slate-500">NIS: {{ $siswa->nis }}</p>
                                            </td>
                                        @endif
                                        <td class="px-6 py-6">
                                            <p class="text-sm text-slate-300">{{ $penilaian->ekskul->nama }}</p>
                                            <p class="text-[10px] text-slate-500">Pelatih: {{ $penilaian->pelatih->nama }}</p>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold">
                                                {{ $penilaian->nilai }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-6">
                                            <p class="text-xs text-slate-400 italic">"{{ $penilaian->keterangan ?? 'Tidak ada catatan.' }}"</p>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-slate-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="text-slate-500 text-sm">Tidak ada siswa yang terdaftar di kelas ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold mb-1">Total Siswa</p>
                <h3 class="text-3xl font-bold text-white">{{ $siswas->count() }}</h3>
            </div>
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold mb-1">Siswa Aktif Ekskul</p>
                <h3 class="text-3xl font-bold text-emerald-500">{{ $siswas->where('penilaians_count', '>', 0)->count() }}</h3>
            </div>
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold mb-1">Rata-rata Nilai Kelas</p>
                @php
                    $allGrades = $siswas->flatMap->penilaians->pluck('nilai');
                    $avg = $allGrades->count() > 0 ? $allGrades->avg() : 0;
                @endphp
                <h3 class="text-3xl font-bold text-blue-500">{{ $allGrades->count() > 0 ? number_format($avg, 1) : '-' }}</h3>
            </div>
        </section>
    </main>
</div>
@endsection
