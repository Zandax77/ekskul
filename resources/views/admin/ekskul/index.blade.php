@extends('layouts.app')

@section('title', 'Manajemen Ekskul - Admin')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    @include('admin.partials.nav')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-white">Kelola Ekskul</h1>
                <p class="text-slate-400">Tambah ekskul baru atau atur penugasan pembina dan pelatih.</p>
            </div>
            <button onclick="document.getElementById('addEkskulForm').classList.toggle('hidden')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(37,99,235,0.2)] flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Tambah Ekskul Baru
            </button>
        </div>

        <!-- Add Ekskul Form -->
        <div id="addEkskulForm" class="hidden mb-12 animate-fade-in">
            <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-8 backdrop-blur-xl">
                <h3 class="text-lg font-bold text-white mb-6">Informasi Ekskul Baru</h3>
                <form action="{{ route('admin.ekskul.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Ekskul</label>
                        <input type="text" name="nama" required placeholder="Contoh: Basket, Pramuka, Robotik" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-sm text-white outline-none focus:border-blue-500 transition-colors">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi (Opsional)</label>
                        <input type="text" name="deskripsi" placeholder="Penjelasan singkat tentang ekskul" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-sm text-white outline-none focus:border-blue-500 transition-colors">
                    </div>
                    <div class="space-y-4 md:col-span-2 bg-white/5 p-4 rounded-2xl border border-white/5">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_wajib" value="1" id="is_wajib_new" class="w-4 h-4 bg-slate-800 border-white/10 rounded text-blue-600 focus:ring-blue-500">
                            <label for="is_wajib_new" class="text-sm font-bold text-white">Jadikan Ekskul Wajib</label>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Target Kelas (jika wajib)</label>
                            <div class="flex gap-4">
                                @foreach(['X', 'XI', 'XII'] as $kelas)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="wajib_kelas[]" value="{{ $kelas }}" class="w-4 h-4 bg-slate-800 border-white/10 rounded text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-slate-300">{{ $kelas }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2 flex justify-end gap-3 mt-4">
                        <button type="button" onclick="document.getElementById('addEkskulForm').classList.add('hidden')" class="px-6 py-3 text-sm font-bold text-slate-400 hover:text-white transition-colors">Batal</button>
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl transition-all">Simpan Ekskul</button>
                    </div>
                </form>
            </div>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm flex items-center gap-3">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm flex items-center gap-3">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10">
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Ekskul</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Pembina</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Pelatih</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($ekskuls as $ekskul)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-bold text-white">{{ $ekskul->nama }}</p>
                                        @if($ekskul->is_wajib)
                                            <span class="px-2 py-0.5 bg-red-500/20 text-red-400 text-[10px] font-black uppercase rounded-md border border-red-500/20">Wajib</span>
                                        @endif
                                    </div>
                                    @if($ekskul->deskripsi)
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $ekskul->deskripsi }}</p>
                                    @endif
                                    @if($ekskul->is_wajib && $ekskul->wajib_kelas)
                                        <p class="text-[10px] text-blue-400 font-bold mt-1 uppercase tracking-tighter">Kelas: {{ $ekskul->wajib_kelas }}</p>
                                    @endif
                                </td>
                                <form action="{{ route('admin.ekskul.update', $ekskul) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <td class="px-6 py-4">
                                        <select name="pembina_id" class="bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-xs text-slate-200 outline-none focus:border-blue-500 transition-colors w-full max-w-[200px]">
                                            <option value="">Pilih Pembina</option>
                                            @foreach($pembinas as $p)
                                                <option value="{{ $p->id }}" {{ $ekskul->pembina_id == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama }} ({{ $p->ekskuls_count }}/3)
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            <select name="pelatih_id" class="bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-xs text-slate-200 outline-none focus:border-blue-500 transition-colors w-full max-w-[200px]">
                                                <option value="">Pilih Pelatih</option>
                                                @foreach($pelatihs as $l)
                                                    <option value="{{ $l->id }}" {{ $ekskul->pelatih_id == $l->id ? 'selected' : '' }}>
                                                        {{ $l->nama }} ({{ $l->ekskuls_count }}/3)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="flex flex-col gap-1.5 p-2 bg-white/5 rounded-lg border border-white/5">
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" name="is_wajib" value="1" {{ $ekskul->is_wajib ? 'checked' : '' }} class="w-3 h-3 bg-slate-800 border-white/10 rounded text-blue-600 focus:ring-blue-500">
                                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Set Wajib</span>
                                                </label>
                                                <div class="flex gap-2">
                                                    @php $currentClasses = explode(',', $ekskul->wajib_kelas ?? ''); @endphp
                                                    @foreach(['X', 'XI', 'XII'] as $kelas)
                                                        <label class="flex items-center gap-1 cursor-pointer">
                                                            <input type="checkbox" name="wajib_kelas[]" value="{{ $kelas }}" {{ in_array($kelas, $currentClasses) ? 'checked' : '' }} class="w-3 h-3 bg-slate-800 border-white/10 rounded text-blue-600 focus:ring-blue-500">
                                                            <span class="text-[10px] text-slate-500">{{ $kelas }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right flex items-center justify-end gap-3">
                                        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-white/10 text-white text-xs font-bold rounded-lg transition-colors">Update</button>
                                </form>
                                        <form action="{{ route('admin.ekskul.destroy', $ekskul) }}" method="POST" onsubmit="return confirm('Hapus ekskul ini?')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-red-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </button>
                                        </form>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out forwards;
        }
    </style>
</div>
@endsection
