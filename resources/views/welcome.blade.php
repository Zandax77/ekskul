@extends('layouts.guest')

@section('title', 'Selamat Datang di EkskulHub')

@section('content')
<div class="relative min-h-screen bg-[#020617] text-slate-200 overflow-x-hidden font-sans">

    {{-- Background glows --}}
    <div class="absolute top-0 left-0 w-[60%] h-[60%] bg-blue-700/15 blur-[180px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[50%] h-[50%] bg-indigo-700/15 blur-[180px] rounded-full pointer-events-none"></div>

    <div class="relative z-10">

        {{-- ===== NAVBAR ===== --}}
        <header class="px-5 sm:px-8 py-5 max-w-7xl mx-auto flex justify-between items-center">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 shrink-0">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-[0_0_20px_rgba(37,99,235,0.35)]">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-xl font-black tracking-tighter text-white">EKSKUL<span class="text-blue-500">HUB</span></span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-400">
                <a href="#features" class="hover:text-white transition-colors">Fitur</a>
                <a href="#portal" class="hover:text-white transition-colors">Portal</a>
                <a href="#portal" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-full transition-all font-semibold">Masuk</a>
            </nav>

            {{-- Mobile hamburger --}}
            <button id="nav-toggle" class="md:hidden p-2 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white transition-colors">
                <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </header>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden md:hidden px-5 pb-4 space-y-2 border-b border-white/5">
            <a href="#features" class="block px-4 py-3 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition-colors text-sm font-medium">Fitur</a>
            <a href="#portal" class="block px-4 py-3 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition-colors text-sm font-medium">Portal Masuk</a>
            <a href="#portal" class="block px-4 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold text-center">Masuk Sekarang</a>
        </div>

        {{-- ===== HERO ===== --}}
        <main class="px-5 sm:px-8 pt-16 pb-20 sm:pt-24 sm:pb-28 max-w-7xl mx-auto text-center">

            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold uppercase tracking-widest mb-8 animate-fade-in">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Sistem Manajemen Terpadu
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black text-white tracking-tight leading-[1.1] mb-6 animate-slide-up">
                Kelola Ekstrakurikuler<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400">Lebih Cerdas.</span>
            </h1>

            <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto mb-10 leading-relaxed animate-slide-up" style="animation-delay:0.1s">
                Platform terpadu untuk sekolah dalam mengelola kegiatan ekstrakurikuler. Pantau kehadiran, jadwal, dan perkembangan siswa dalam satu dashboard terintegrasi.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-16 sm:mb-24 animate-slide-up" style="animation-delay:0.2s">
                <a href="#portal" class="w-full sm:w-auto px-8 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl transition-all shadow-[0_0_30px_rgba(37,99,235,0.3)] hover:scale-105 active:scale-95 text-sm">
                    Mulai Sekarang
                </a>
                <a href="#features" class="w-full sm:w-auto px-8 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold rounded-2xl transition-all text-sm">
                    Pelajari Fitur
                </a>
            </div>

            {{-- Stats bar --}}
            <div class="grid grid-cols-3 gap-4 max-w-lg mx-auto animate-slide-up" style="animation-delay:0.3s">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                    <p class="text-2xl font-black text-white">3+</p>
                    <p class="text-xs text-slate-500 mt-1">Peran Pengguna</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                    <p class="text-2xl font-black text-white">100%</p>
                    <p class="text-xs text-slate-500 mt-1">Digital</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                    <p class="text-2xl font-black text-white">Real-time</p>
                    <p class="text-xs text-slate-500 mt-1">Laporan</p>
                </div>
            </div>
        </main>

        {{-- ===== PORTAL SECTION ===== --}}
        <section id="portal" class="px-5 sm:px-8 py-16 sm:py-24 bg-slate-900/40 backdrop-blur-xl border-y border-white/5">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-10 sm:mb-14">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3">Pilih Portal Masuk</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-md mx-auto">Silakan pilih akses sesuai peran Anda di sekolah.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                    {{-- Siswa --}}
                    <a href="{{ route('login') }}" class="group relative rounded-3xl p-px overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl"></div>
                        <div class="relative bg-slate-950 border border-white/10 rounded-[calc(1.5rem-1px)] p-7 sm:p-8 flex flex-col h-full group-hover:border-transparent transition-colors">
                            <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 mb-6 border border-blue-500/20 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Portal Siswa</h3>
                            <p class="text-slate-400 text-sm mb-6 flex-grow leading-relaxed">Akses jadwal, daftar ekskul baru, dan lihat catatan prestasi Anda.</p>
                            <div class="flex items-center text-blue-400 font-bold gap-1.5 text-xs uppercase tracking-wider">
                                Masuk <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Staff --}}
                    <a href="{{ route('staff.login') }}" class="group relative rounded-3xl p-px overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl"></div>
                        <div class="relative bg-slate-950 border border-white/10 rounded-[calc(1.5rem-1px)] p-7 sm:p-8 flex flex-col h-full group-hover:border-transparent transition-colors">
                            <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 border border-emerald-500/20 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Portal Staff</h3>
                            <p class="text-slate-400 text-sm mb-6 flex-grow leading-relaxed">Kelola absensi, buat laporan kegiatan, dan atur jadwal latihan ekskul.</p>
                            <div class="flex items-center text-emerald-400 font-bold gap-1.5 text-xs uppercase tracking-wider">
                                Masuk <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Admin --}}
                    <a href="{{ route('admin.login') }}" class="group relative rounded-3xl p-px overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-rose-500 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl"></div>
                        <div class="relative bg-slate-950 border border-white/10 rounded-[calc(1.5rem-1px)] p-7 sm:p-8 flex flex-col h-full group-hover:border-transparent transition-colors">
                            <div class="w-12 h-12 bg-rose-500/10 rounded-2xl flex items-center justify-center text-rose-400 mb-6 border border-rose-500/20 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Admin Central</h3>
                            <p class="text-slate-400 text-sm mb-6 flex-grow leading-relaxed">Kendali penuh sistem, manajemen data master, dan pengaturan kebijakan ekskul.</p>
                            <div class="flex items-center text-rose-400 font-bold gap-1.5 text-xs uppercase tracking-wider">
                                Masuk <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </section>

        {{-- ===== FEATURES SECTION ===== --}}
        <section id="features" class="px-5 sm:px-8 py-16 sm:py-24 max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3">Fitur Unggulan</h2>
                <p class="text-slate-400 text-sm sm:text-base max-w-md mx-auto">Semua yang Anda butuhkan untuk mengelola ekskul secara profesional.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="bg-slate-900/60 border border-white/8 rounded-2xl p-6 hover:border-blue-500/30 transition-colors group">
                    <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-400 mb-4 group-hover:bg-blue-500/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Absensi Digital</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Pencatatan kehadiran otomatis dengan laporan real-time yang akurat.</p>
                </div>

                <div class="bg-slate-900/60 border border-white/8 rounded-2xl p-6 hover:border-indigo-500/30 transition-colors group">
                    <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400 mb-4 group-hover:bg-indigo-500/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Jadwal Dinamis</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Kelola jadwal latihan dengan mudah dan pantau perubahan secara langsung.</p>
                </div>

                <div class="bg-slate-900/60 border border-white/8 rounded-2xl p-6 hover:border-emerald-500/30 transition-colors group">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400 mb-4 group-hover:bg-emerald-500/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Analitik Performa</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Pantau pertumbuhan minat dan bakat siswa melalui data statistik visual.</p>
                </div>

                <div class="bg-slate-900/60 border border-white/8 rounded-2xl p-6 hover:border-rose-500/30 transition-colors group">
                    <div class="w-10 h-10 bg-rose-500/10 rounded-xl flex items-center justify-center text-rose-400 mb-4 group-hover:bg-rose-500/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Catatan Prestasi</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Dokumentasikan setiap pencapaian siswa lengkap dengan foto dan sertifikat.</p>
                </div>

                <div class="bg-slate-900/60 border border-white/8 rounded-2xl p-6 hover:border-amber-500/30 transition-colors group">
                    <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-400 mb-4 group-hover:bg-amber-500/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Manajemen Anggota</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Kelola keanggotaan ekskul, pendaftaran siswa, dan penugasan pelatih.</p>
                </div>

                <div class="bg-slate-900/60 border border-white/8 rounded-2xl p-6 hover:border-purple-500/30 transition-colors group">
                    <div class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-400 mb-4 group-hover:bg-purple-500/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Laporan Lengkap</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Ekspor laporan kegiatan dan kehadiran untuk keperluan administrasi sekolah.</p>
                </div>
            </div>
        </section>

        {{-- ===== FOOTER ===== --}}
        <footer class="px-5 sm:px-8 py-12 border-t border-white/5 text-center">
            <div class="flex flex-col items-center gap-5">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600/20 rounded-lg flex items-center justify-center text-blue-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    </div>
                    <span class="text-lg font-bold tracking-tighter text-white">EkskulHub</span>
                </div>
                <p class="text-slate-500 text-sm max-w-xs mx-auto">Membangun masa depan siswa melalui kegiatan ekstrakurikuler yang terorganisir.</p>
                <div class="flex flex-wrap justify-center gap-5 text-slate-500 text-xs mt-2">
                    <a href="#" class="hover:text-white transition-colors">Syarat &amp; Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Kontak Kami</a>
                </div>
                <p class="text-slate-700 text-xs">&copy; {{ date('Y') }} EkskulHub. Developed with ❤️ for Schools.</p>
            </div>
        </footer>

    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in  { animation: fade-in  0.7s ease-out forwards; }
    .animate-slide-up { animation: slide-up 0.7s ease-out both; }
    html { scroll-behavior: smooth; }
</style>

<script>
    const toggle = document.getElementById('nav-toggle');
    const menu   = document.getElementById('mobile-menu');
    const iconOpen  = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    toggle.addEventListener('click', () => {
        const isHidden = menu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden', !isHidden);
        iconClose.classList.toggle('hidden', isHidden);
    });

    // Close mobile menu on link click
    menu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            menu.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        });
    });
</script>
@endsection
