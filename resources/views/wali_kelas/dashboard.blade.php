@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas - ' . $waliKelas->kelas)

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 w-full">
                <div class="flex items-center gap-3">
                    @php $logo = \App\Models\Setting::get('logo_sekolah'); @endphp
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-10 w-auto">
                    @else
                        <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-800 shadow-lg shadow-emerald-600/20">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-lg font-bold text-white">{{ \App\Models\Setting::get('nama_sekolah', 'EkskulHub') }}</h1>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Wali Kelas: {{ $waliKelas->nama }}</p>
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
            <h2 class="text-2xl font-bold text-white mb-2">Laporan Kehadiran & Nilai</h2>
            <p class="text-slate-400 text-sm">Monitor tingkat kehadiran bulanan dan rekap nilai siswa kelas {{ $waliKelas->kelas }}.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Statistik Bulanan Kelas -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <h3 class="text-sm font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Tingkat Kehadiran Kelas (Per Bulan)
                </h3>
                <div class="space-y-4">
                    @forelse($monthlyAttendance as $ma)
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs text-slate-400">{{ $ma->month_name }}</span>
                                <span class="text-xs font-bold text-white">{{ $ma->percentage }}%</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ $ma->percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-xs italic">Belum ada data kehadiran bulan ini.</p>
                    @endforelse
                </div>
            </div>

            <!-- Histori Ketidakhadiran Siswa -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <h3 class="text-sm font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Histori Siswa Tidak Hadir
                </h3>
                <div class="space-y-3 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($absenceHistory as $abs)
                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-2xl border border-white/5">
                            <div>
                                <p class="text-xs font-bold text-white">{{ $abs->siswa->nama }}</p>
                                <p class="text-[10px] text-slate-500">{{ $abs->ekskul_nama }} • {{ \Carbon\Carbon::parse($abs->tanggal)->translatedFormat('d M Y') }}</p>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $abs->status == 'alfa' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                {{ $abs->status }}
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-6">
                            <svg class="w-8 h-8 text-slate-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <p class="text-slate-500 text-xs italic">Belum ada catatan ketidakhadiran.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <header class="pt-8">
            <h2 class="text-xl font-bold text-white mb-2">Rekap Nilai Siswa</h2>
            <p class="text-slate-400 text-sm">Daftar nilai akhir ekstrakurikuler siswa di kelas {{ $waliKelas->kelas }}.</p>
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
