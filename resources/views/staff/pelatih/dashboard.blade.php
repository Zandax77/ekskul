@extends('layouts.app')

@section('title', 'Dashboard Pelatih - ' . config('app.name', 'Ekskul'))

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    @php $logo = \App\Models\Setting::get('logo_sekolah'); @endphp
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-8 w-auto">
                    @else
                        <div class="h-8 w-8 rounded-lg bg-blue-600 flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    @endif
                    <span class="text-xl font-bold text-white tracking-tight">{{ \App\Models\Setting::get('nama_sekolah', 'EkskulHub') }} <span class="text-blue-400 text-sm ml-2 font-black uppercase tracking-widest">PELATIH</span></span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-400">{{ Auth::guard('pelatih')->user()->nama }}</span>
                    <form action="{{ route('staff.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-red-400 hover:text-red-300">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-white mb-8">Ekskul yang Anda Latih</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($ekskuls as $ekskul)
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 hover:border-blue-500/50 transition-all group">
                    <h2 class="text-xl font-bold text-white mb-2">{{ $ekskul->nama }}</h2>
                    <p class="text-sm text-slate-400 mb-6">{{ $ekskul->siswas->count() }} Anggota Terdaftar</p>
                    
                    <a href="{{ route('pelatih.ekskul.show', $ekskul) }}" class="inline-flex items-center justify-center w-full py-3 rounded-xl bg-blue-600 text-sm font-semibold text-white hover:bg-blue-500 transition-colors">
                        Kelola Latihan
                    </a>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection
