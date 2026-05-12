<nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white tracking-tight">EkskulHub <span class="text-red-500 text-sm ml-2 font-black">ADMIN</span></a>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }}">Dashboard</a>
                    <a href="{{ route('admin.ekskul.index') }}" class="text-sm {{ request()->routeIs('admin.ekskul.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }}">Ekskul</a>
                    <a href="{{ route('admin.staff.index') }}" class="text-sm {{ request()->routeIs('admin.staff.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }}">Staf</a>
                    <a href="{{ route('admin.siswa.index') }}" class="text-sm {{ request()->routeIs('admin.siswa.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }}">Siswa</a>
                    <a href="{{ route('admin.wali-kelas.index') }}" class="text-sm {{ request()->routeIs('admin.wali-kelas.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }}">Wali Kelas</a>
                    <a href="{{ route('admin.journal.index') }}" class="text-sm {{ request()->routeIs('admin.journal.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }}">Jurnal</a>
                    <a href="{{ route('admin.settings.index') }}" class="text-sm {{ request()->routeIs('admin.settings.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }}">Pengaturan</a>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition-colors">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>
