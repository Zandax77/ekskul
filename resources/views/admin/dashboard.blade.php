@extends('layouts.app')

@section('title', 'Admin Dashboard - ' . config('app.name', 'Ekskul'))

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    @include('admin.partials.nav')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-white">Ringkasan Sistem</h1>
            <p class="text-slate-400 mt-2">Pantau dan kelola seluruh entitas sekolah dari sini.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Total Siswa</p>
                <h3 class="text-4xl font-bold text-white">{{ $stats['siswa'] }}</h3>
            </div>
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Total Pembina</p>
                <h3 class="text-4xl font-bold text-white">{{ $stats['pembina'] }}</h3>
            </div>
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Total Pelatih</p>
                <h3 class="text-4xl font-bold text-white">{{ $stats['pelatih'] }}</h3>
            </div>
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Total Wali Kelas</p>
                <h3 class="text-4xl font-bold text-white">{{ $stats['wali_kelas'] }}</h3>
            </div>
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Total Ekskul</p>
                <h3 class="text-4xl font-bold text-white">{{ $stats['ekskul'] }}</h3>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 hover:bg-slate-800/50 transition-colors group">
                <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1 group-hover:text-blue-400">Pengaturan</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-xl font-bold text-white">Sekolah</h3>
                    <svg class="w-6 h-6 text-slate-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </a>
        </div>

        <div class="mt-12 mb-12 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gradient-to-br from-blue-600/20 to-indigo-600/20 border border-white/10 rounded-3xl p-8 relative overflow-hidden group">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-white mb-4">Kelola Penugasan</h2>
                    <p class="text-slate-300 mb-6">Atur pembina dan pelatih untuk setiap ekstrakurikuler. Pastikan batas maksimal 3 ekskul per staf terpenuhi.</p>
                    <a href="{{ route('admin.ekskul.index') }}" class="inline-flex items-center gap-2 text-blue-400 font-bold hover:text-blue-300 transition-colors">
                        Buka Manajemen Ekskul
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
                <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-blue-600/10 blur-3xl group-hover:bg-blue-600/20 transition-all"></div>
            </div>

            <div class="bg-gradient-to-br from-emerald-600/20 to-teal-600/20 border border-white/10 rounded-3xl p-8 relative overflow-hidden group">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-white mb-4">Manajemen Staf</h2>
                    <p class="text-slate-300 mb-6">Pantau beban kerja para pembina dan pelatih. Lihat seberapa banyak ekskul yang mereka tangani.</p>
                    <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center gap-2 text-emerald-400 font-bold hover:text-emerald-300 transition-colors">
                        Lihat Daftar Staf
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
                <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-emerald-600/10 blur-3xl group-hover:bg-emerald-600/20 transition-all"></div>
            </div>

            <div class="bg-gradient-to-br from-amber-600/20 to-orange-600/20 border border-white/10 rounded-3xl p-8 relative overflow-hidden group md:col-span-2 lg:col-span-1">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-white mb-4">Manajemen Wali Kelas</h2>
                    <p class="text-slate-300 mb-6">Kelola data guru pengampu kelas. Import data secara massal dari Excel untuk mempercepat proses input.</p>
                    <a href="{{ route('admin.wali-kelas.index') }}" class="inline-flex items-center gap-2 text-amber-400 font-bold hover:text-amber-300 transition-colors">
                        Buka Portal Wali Kelas
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
                <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-amber-600/10 blur-3xl group-hover:bg-amber-600/20 transition-all"></div>
            </div>
        </div>

        <!-- NEW: Chart & Prestasi -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Grafik Peserta Ekskul -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <h2 class="text-xl font-bold text-white mb-6">Grafik Peserta Ekskul</h2>
                <div class="relative h-64 w-full">
                    <canvas id="pesertaChart"></canvas>
                </div>
            </div>

            <!-- Prestasi Terbaru -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 overflow-hidden flex flex-col">
                <h2 class="text-xl font-bold text-white mb-6">Prestasi Terbaru</h2>
                <div class="flex-1 overflow-y-auto pr-2" style="max-height: 256px;">
                    @forelse($prestasis as $p)
                        <div class="mb-4 p-4 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-sm font-bold text-white">{{ $p->judul }}</h4>
                                <span class="text-[10px] font-bold px-2 py-1 bg-amber-500/20 text-amber-400 rounded-lg whitespace-nowrap ml-2">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</span>
                            </div>
                            <p class="text-xs text-slate-400 mb-2">Oleh: <span class="text-slate-200 font-semibold">{{ $p->siswa->nama ?? '-' }}</span></p>
                            <span class="inline-block text-[10px] uppercase tracking-wider font-bold text-blue-400 bg-blue-400/10 px-2 py-1 rounded-md">{{ $p->ekskul->nama ?? '-' }}</span>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-slate-500 text-sm">Belum ada data prestasi.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- NEW: Rekap Kehadiran -->
        <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 mb-8">
            <h2 class="text-xl font-bold text-white mb-6">Rekap Kehadiran per Ekskul</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="py-3 px-4 text-xs font-bold uppercase text-slate-500">Nama Ekskul</th>
                            <th class="py-3 px-4 text-xs font-bold uppercase text-slate-500">Jumlah Peserta</th>
                            <th class="py-3 px-4 text-xs font-bold uppercase text-slate-500">Total Presensi</th>
                            <th class="py-3 px-4 text-xs font-bold uppercase text-slate-500 min-w-[200px]">Tingkat Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($attendanceRecap as $recap)
                            @php
                                $totalPotential = $recap->total_kegiatan * $recap->total_peserta;
                                $percentage = $totalPotential > 0 ? round(($recap->total_hadir / $totalPotential) * 100) : 0;
                                // Adjusted thresholds: >= 70% is now emerald
                                $statusColor = $percentage >= 70 ? 'emerald' : ($percentage >= 50 ? 'amber' : 'red');
                            @endphp
                            <tr class="group hover:bg-white/5 transition-all duration-300">
                                <td class="py-4 px-4 text-sm font-medium text-white relative">
                                    <!-- Dynamic Vertical Line -->
                                    <div class="absolute left-0 top-2 bottom-2 w-1.5 rounded-r-full transition-all duration-500 {{ $statusColor === 'emerald' ? 'bg-emerald-500 shadow-[2px_0_12px_rgba(16,185,129,0.6)]' : ($statusColor === 'amber' ? 'bg-amber-500 shadow-[2px_0_12px_rgba(245,158,11,0.6)]' : 'bg-red-500 shadow-[2px_0_12px_rgba(239,68,68,0.6)]') }}"></div>
                                    <span class="pl-4 group-hover:pl-5 transition-all duration-300">{{ $recap->nama }}</span>
                                </td>
                                <td class="py-4 px-4 text-sm text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        {{ $recap->total_peserta }} Siswa
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        {{ $recap->total_hadir }} / {{ $recap->total_kegiatan * $recap->total_peserta }} Hadir
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-1 min-w-[50px]">
                                            <span class="text-lg font-black leading-none {{ $statusColor === 'emerald' ? 'text-emerald-400' : ($statusColor === 'amber' ? 'text-amber-400' : 'text-red-400') }}">
                                                {{ $percentage }}<span class="text-[10px] ml-0.5">%</span>
                                            </span>
                                        </div>
                                        <div class="flex-1 h-3 bg-slate-800 rounded-full overflow-hidden border border-white/5">
                                            <div class="h-full rounded-full {{ $statusColor === 'emerald' ? 'bg-emerald-500' : ($statusColor === 'amber' ? 'bg-amber-500' : 'bg-red-500') }}" 
                                                 style="width: {{ $percentage }}%; min-width: {{ $percentage > 0 ? '2px' : '0' }}; transition: width 1s ease-in-out;">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if(count($attendanceRecap) === 0)
                            <tr>
                                <td colspan="4" class="py-8 text-center text-sm text-slate-500">Belum ada data kehadiran.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('pesertaChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Jumlah Peserta',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#94a3b8'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#94a3b8'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
