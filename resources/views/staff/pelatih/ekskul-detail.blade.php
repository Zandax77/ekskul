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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Statistik Bulanan -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <h3 class="text-sm font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Kehadiran Bulanan
                </h3>
                <div class="h-[200px] w-full">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

            <!-- Grafik Status Absen -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <h3 class="text-sm font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Distribusi Ketidakhadiran
                </h3>
                <div class="h-[200px] w-full">
                    <canvas id="absenteeChart"></canvas>
                </div>
            </div>

            <!-- Rekap Ketidakhadiran -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <h3 class="text-sm font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Siswa Sering Absen
                </h3>
                <div class="space-y-4 max-h-[200px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($absenteeRecap as $siswaId => $records)
                        @php $siswa = $records->first()->siswa; @endphp
                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-2xl">
                            <div>
                                <p class="text-xs font-bold text-white">{{ $siswa->nama }}</p>
                                <p class="text-[10px] text-slate-500">Kelas: {{ $siswa->kelas ?? '-' }}</p>
                            </div>
                            <div class="flex gap-2">
                                @foreach($records as $rec)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $rec->status == 'alfa' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                        {{ $rec->status }}: {{ $rec->count }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-xs italic">Semua siswa rajin hadir.</p>
                    @endforelse
                </div>
            </div>
        </div>

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
                                    <div class="flex gap-2">
                                        <a href="{{ route('pelatih.presensi.scan', $kegiatan) }}" class="px-4 py-2 rounded-xl bg-blue-600/20 border border-blue-500/30 text-xs font-bold text-blue-400 hover:bg-blue-600/30 transition-all flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            Scan QR
                                        </a>
                                        <a href="{{ route('pelatih.presensi', $kegiatan) }}" class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-xs font-bold text-white hover:bg-white/10 transition-colors">
                                            Catat Manual
                                        </a>
                                    </div>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const labels = {!! json_encode($monthlyAttendance->reverse()->pluck('month_name')) !!};
        const data = {!! json_encode($monthlyAttendance->reverse()->pluck('percentage')) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Persentase Kehadiran',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.4)',
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    borderRadius: 10,
                    hoverBackgroundColor: 'rgba(59, 130, 246, 0.6)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '% Kehadiran';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
                        ticks: { color: '#64748b', font: { size: 10 }, stepSize: 25 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 10 } }
                    }
                }
            }
        });

        // Absentee Distribution Chart
        const absenteeCtx = document.getElementById('absenteeChart').getContext('2d');
        const absenteeData = {
            labels: ['Alfa', 'Izin', 'Sakit'],
            datasets: [{
                data: [
                    {{ $absenteeDistribution['alfa'] ?? 0 }},
                    {{ $absenteeDistribution['izin'] ?? 0 }},
                    {{ $absenteeDistribution['sakit'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(239, 68, 68, 0.6)',   // red-500
                    'rgba(245, 158, 11, 0.6)',  // amber-500
                    'rgba(16, 185, 129, 0.6)'   // emerald-500
                ],
                borderColor: [
                    '#ef4444',
                    '#f59e0b',
                    '#10b981'
                ],
                borderWidth: 2,
                hoverOffset: 10
            }]
        };

        new Chart(absenteeCtx, {
            type: 'doughnut',
            data: absenteeData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 10 }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 12,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.parsed + ' kali';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
