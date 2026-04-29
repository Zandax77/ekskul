@extends('layouts.app')

@section('title', 'Manajemen Staf - Admin')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white tracking-tight">EkskulHub <span class="text-red-500 text-sm ml-2 font-black">ADMIN</span></a>
                </div>
                <div class="flex items-center gap-6">
                    <div class="flex gap-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Dashboard</a>
                        <a href="{{ route('admin.ekskul.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Ekskul</a>
                        <a href="{{ route('admin.staff.index') }}" class="text-sm text-white font-medium">Staf</a>
                        <a href="{{ route('admin.siswa.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Siswa</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-8">Manajemen Staf</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Manual Add -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase mb-4">Tambah Staf Manual</h3>
                <form action="{{ route('admin.staff.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <input type="text" name="nama" placeholder="Nama Lengkap" required class="bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-emerald-500">
                    <input type="text" name="nip" placeholder="NIP" required class="bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-emerald-500">
                    <select name="role" required class="bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-emerald-500">
                        <option value="pembina">Pembina</option>
                        <option value="pelatih">Pelatih</option>
                    </select>
                    <input type="password" name="password" placeholder="Sandi Default" required class="bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-emerald-500">
                    <div class="sm:col-span-2 flex justify-end">
                        <button type="submit" class="px-8 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-emerald-600/20">Simpan Staf</button>
                    </div>
                </form>
            </div>

            <!-- Excel Import -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-slate-500 uppercase">Import Data Staff</h3>
                        <a href="{{ route('admin.staff.template') }}" class="text-[10px] font-bold text-emerald-400 hover:text-emerald-300 flex items-center gap-1 uppercase tracking-wider">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Unduh Template
                        </a>
                    </div>
                    <form action="{{ route('admin.staff.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="relative group">
                            <input type="file" name="file" required 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="bg-slate-800/50 border-2 border-dashed border-white/10 rounded-2xl p-6 text-center group-hover:border-emerald-500/50 transition-all">
                                <svg class="h-8 w-8 text-slate-500 mx-auto mb-2 group-hover:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p class="text-xs text-slate-400">Klik atau seret file Excel (.xlsx, .csv) di sini</p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-2.5 bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-black/20">Proses Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pembina List -->
            <div class="space-y-4">
                <h2 class="text-lg font-bold text-slate-400 uppercase tracking-widest px-2">Pembina</h2>
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/10">
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">Nama / NIP</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 text-center">Ekskul</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($pembinas as $p)
                                <tr class="hover:bg-white/5">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-white">{{ $p->nama }}</p>
                                        <p class="text-[10px] text-slate-500">NIP: {{ $p->nip }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $p->ekskuls_count >= 3 ? 'bg-red-500/20 text-red-400' : 'bg-blue-500/20 text-blue-400' }}">
                                            {{ $p->ekskuls_count }} / 3
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pelatih List -->
            <div class="space-y-4">
                <h2 class="text-lg font-bold text-slate-400 uppercase tracking-widest px-2">Pelatih</h2>
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/10">
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">Nama / NIP</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 text-center">Ekskul</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($pelatihs as $l)
                                <tr class="hover:bg-white/5">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-white">{{ $l->nama }}</p>
                                        <p class="text-[10px] text-slate-500">NIP: {{ $l->nip }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $l->ekskuls_count >= 3 ? 'bg-red-500/20 text-red-400' : 'bg-emerald-500/20 text-emerald-400' }}">
                                            {{ $l->ekskuls_count }} / 3
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
