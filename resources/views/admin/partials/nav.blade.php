<nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white tracking-tight">EkskulHub <span class="text-red-500 text-sm ml-2 font-black">ADMIN</span></a>
            </div>

            <!-- Mobile: hamburger + dropdown -->
            <div class="md:hidden flex items-center gap-3">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition-colors">Keluar</button>
                </form>

                <button id="adminMenuBtn" type="button" class="inline-flex items-center justify-center p-2 rounded-xl border border-white/10 bg-slate-800/40 hover:bg-slate-800 transition-all" aria-label="Buka menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop: nav links -->
            <div class="hidden md:flex items-center gap-6">
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

        <!-- Mobile dropdown menu -->
        <div id="adminMenu" class="md:hidden hidden pb-4">
            <div class="mt-2 rounded-3xl border border-white/10 bg-slate-900/70 backdrop-blur-xl overflow-hidden">
                <div class="flex flex-col p-3 gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }} py-2 px-3 rounded-xl hover:bg-white/5">Dashboard</a>
                    <a href="{{ route('admin.ekskul.index') }}" class="text-sm {{ request()->routeIs('admin.ekskul.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }} py-2 px-3 rounded-xl hover:bg-white/5">Ekskul</a>
                    <a href="{{ route('admin.staff.index') }}" class="text-sm {{ request()->routeIs('admin.staff.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }} py-2 px-3 rounded-xl hover:bg-white/5">Staf</a>
                    <a href="{{ route('admin.siswa.index') }}" class="text-sm {{ request()->routeIs('admin.siswa.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }} py-2 px-3 rounded-xl hover:bg-white/5">Siswa</a>
                    <a href="{{ route('admin.wali-kelas.index') }}" class="text-sm {{ request()->routeIs('admin.wali-kelas.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }} py-2 px-3 rounded-xl hover:bg-white/5">Wali Kelas</a>
                    <a href="{{ route('admin.journal.index') }}" class="text-sm {{ request()->routeIs('admin.journal.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }} py-2 px-3 rounded-xl hover:bg-white/5">Jurnal</a>
                    <a href="{{ route('admin.settings.index') }}" class="text-sm {{ request()->routeIs('admin.settings.*') ? 'text-white font-medium' : 'text-slate-400 hover:text-white transition-colors' }} py-2 px-3 rounded-xl hover:bg-white/5">Pengaturan</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const btn = document.getElementById('adminMenuBtn');
            const menu = document.getElementById('adminMenu');
            if (!btn || !menu) return;

            function toggle() {
                menu.classList.toggle('hidden');
            }

            btn.addEventListener('click', function (e) {
                // Prevent the "click outside" handler from immediately closing
                e.stopPropagation();
                toggle();
            });

            // close menu when clicking outside
            document.addEventListener('click', function (e) {
                if (menu.classList.contains('hidden')) return;

                const clickedInsideMenu = menu.contains(e.target);
                const clickedHamburger = btn.contains(e.target);

                if (!clickedInsideMenu && !clickedHamburger) {
                    menu.classList.add('hidden');
                }
            });
        })();
    </script>
</nav>

