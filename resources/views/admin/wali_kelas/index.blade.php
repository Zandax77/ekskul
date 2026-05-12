@extends('layouts.app')

@section('title', 'Manajemen Wali Kelas - Admin')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    @include('admin.partials.nav')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-8">Manajemen Wali Kelas</h1>

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

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <!-- Quick Add Form -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase mb-4">Tambah Wali Kelas Manual</h3>
                <form action="{{ route('admin.wali-kelas.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <input type="text" name="nama" placeholder="Nama Lengkap" required class="bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-blue-500">
                    <input type="text" name="nip" placeholder="NIP" required class="bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-blue-500">
                    <input type="text" name="kelas" placeholder="Kelas (Contoh: X MIPA 1)" required class="bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-blue-500">
                    <input type="password" name="password" placeholder="Sandi Default" required class="bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-slate-200 outline-none focus:border-blue-500">
                    <div class="sm:col-span-2 flex justify-end">
                        <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-blue-600/20">Simpan Wali Kelas</button>
                    </div>
                </form>
            </div>

            <!-- Excel Import Form -->
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-slate-500 uppercase">Import Data Excel</h3>
                        <a href="{{ route('admin.wali-kelas.template') }}" class="text-[10px] font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1 uppercase tracking-wider">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Unduh Template
                        </a>
                    </div>
                    <form action="{{ route('admin.wali-kelas.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="relative group">
                            <input type="file" name="file" required 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="bg-slate-800/50 border-2 border-dashed border-white/10 rounded-2xl p-6 text-center group-hover:border-amber-500/50 transition-all">
                                <svg class="h-8 w-8 text-slate-500 mx-auto mb-2 group-hover:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 border-b border-white/10">
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">Nama / NIP</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">Kelas Diampu</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($waliKelas as $w)
                        <tr class="hover:bg-white/5">
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-white">{{ $w->nama }}</p>
                                <p class="text-[10px] text-slate-500">NIP: {{ $w->nip }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-amber-500/10 text-amber-400 text-xs font-bold rounded-full border border-amber-500/20">{{ $w->kelas }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('admin.wali-kelas.reset', $w) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Reset password wali kelas ini menjadi 12345678?')" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white text-[10px] font-bold rounded-lg border border-white/10 transition-all uppercase tracking-wider">Reset Pass</button>
                                    </form>
                                    <form action="{{ route('admin.wali-kelas.destroy', $w) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus data wali kelas ini?')" class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-500 text-[10px] font-bold rounded-lg border border-red-500/20 transition-all uppercase tracking-wider">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-500 text-sm">Belum ada data wali kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
