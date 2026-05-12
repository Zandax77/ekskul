@extends('layouts.app')

@section('title', 'Rekap Jurnal Kegiatan - Admin')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    @include('admin.partials.nav')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">Rekap Jurnal Kegiatan</h1>
                <p class="text-sm text-slate-500 mt-1">Laporan materi dan kegiatan dari seluruh pelatih ekstrakurikuler.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($journals as $j)
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden group hover:border-blue-500/30 transition-all shadow-2xl">
                    @if($j->foto_kegiatan)
                        <div class="aspect-video w-full overflow-hidden relative">
                            <img src="{{ Storage::url($j->foto_kegiatan) }}" alt="Foto Kegiatan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="px-2 py-1 bg-blue-600 text-[10px] font-bold text-white rounded uppercase tracking-wider">{{ $j->ekskul->nama }}</span>
                            </div>
                        </div>
                    @else
                        <div class="p-6 border-b border-white/5 bg-white/5">
                             <span class="px-2 py-1 bg-slate-800 text-[10px] font-bold text-slate-400 rounded uppercase tracking-wider">{{ $j->ekskul->nama }}</span>
                        </div>
                    @endif

                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d F Y') }}</p>
                                <h4 class="text-white font-bold mt-1">{{ $j->materi }}</h4>
                            </div>
                        </div>

                        @if($j->catatan)
                            <div class="p-3 bg-white/5 rounded-xl border border-white/5">
                                <p class="text-[11px] text-slate-400 italic">"{{ $j->catatan }}"</p>
                            </div>
                        @endif

                        <div class="flex items-center gap-4 py-2">
                            <div class="h-24 w-24 shrink-0">
                                <canvas id="chart-{{ $j->id }}"></canvas>
                            </div>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-1 flex-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] text-slate-400">Hadir: <span class="text-white font-bold">{{ $j->total_hadir }}</span></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                    <span class="text-[10px] text-slate-400">Izin: <span class="text-white font-bold">{{ $j->total_izin }}</span></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    <span class="text-[10px] text-slate-400">Sakit: <span class="text-white font-bold">{{ $j->total_sakit }}</span></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                    <span class="text-[10px] text-slate-400">Alfa: <span class="text-white font-bold">{{ $j->total_alfa }}</span></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
                            <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-[10px] font-bold text-blue-400 border border-white/5">
                                {{ strtoupper(substr($j->ekskul->pelatih->nama ?? 'PL', 0, 2)) }}
                            </div>
                            <div class="text-[10px]">
                                <p class="text-slate-300 font-bold">{{ $j->ekskul->pelatih->nama ?? 'Tidak ada pelatih' }}</p>
                                <p class="text-slate-500">Pelatih Ekskul</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-slate-900/30 rounded-3xl border border-dashed border-white/10">
                    <p class="text-slate-500">Belum ada jurnal kegiatan yang dibuat.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($journals as $j)
        const ctx_{{ $j->id }} = document.getElementById('chart-{{ $j->id }}').getContext('2d');
        new Chart(ctx_{{ $j->id }}, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Izin', 'Sakit', 'Alfa'],
                datasets: [{
                    data: [{{ $j->total_hadir }}, {{ $j->total_izin }}, {{ $j->total_sakit }}, {{ $j->total_alfa }}],
                    backgroundColor: [
                        '#10b981', // emerald-500
                        '#3b82f6', // blue-500
                        '#f59e0b', // amber-500
                        '#ef4444'  // red-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 8,
                        cornerRadius: 8,
                        titleFont: { size: 10 },
                        bodyFont: { size: 10 },
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
        @endforeach
    });
</script>
@endpush
