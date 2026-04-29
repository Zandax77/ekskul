@extends('layouts.app')

@section('title', 'Penilaian Ekskul - ' . $ekskul->nama)

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16 gap-4">
                <a href="{{ route('pelatih.ekskul.show', $ekskul->id) }}" class="text-slate-400 hover:text-white transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-white">Kelola Nilai: {{ $ekskul->nama }}</h1>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-white/10">
                <h2 class="text-lg font-bold text-white">Daftar Anggota Ekskul</h2>
                <p class="text-sm text-slate-500">Berikan penilaian akhir dan catatan evaluasi kepada setiap siswa.</p>
            </div>

            <form action="{{ route('pelatih.penilaian.store', $ekskul->id) }}" method="POST">
                @csrf
                <div class="divide-y divide-white/5">
                    @forelse($ekskul->siswas as $siswa)
                        @php
                            $penilaian = $siswa->penilaians->first();
                            $nilai = $penilaian?->nilai ?? '';
                            $keterangan = $penilaian?->keterangan ?? '';
                        @endphp
                        <div class="p-6 hover:bg-white/5 transition-colors grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                            <div class="flex items-center gap-3 md:col-span-1">
                                <div class="h-10 w-10 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center text-blue-400 font-bold shrink-0">
                                    {{ substr($siswa->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">{{ $siswa->nama }}</p>
                                    <p class="text-xs text-slate-500">NIS: {{ $siswa->nis }}</p>
                                    @if($siswa->kelas)
                                        <p class="text-[10px] uppercase text-slate-500">Kelas: {{ $siswa->kelas }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nilai Akhir (A/B/C/Angka)</label>
                                    <input type="text" name="penilaian[{{ $siswa->id }}][nilai]" value="{{ $nilai }}" required placeholder="Contoh: A, B, atau 85" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Evaluasi (Opsional)</label>
                                    <textarea name="penilaian[{{ $siswa->id }}][keterangan]" rows="2" placeholder="Tuliskan perkembangan atau catatan khusus..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2 text-sm text-slate-200 outline-none focus:border-blue-500">{{ $keterangan }}</textarea>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500">
                            Belum ada siswa yang mendaftar ke ekstrakurikuler ini.
                        </div>
                    @endforelse
                </div>

                @if($ekskul->siswas->count() > 0)
                    <div class="p-6 bg-slate-900/80 border-t border-white/10">
                        <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-sm font-bold text-white shadow-lg shadow-blue-600/20 hover:from-blue-500 hover:to-indigo-500 transition-all">
                            Simpan Semua Nilai
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </main>
</div>
@endsection
