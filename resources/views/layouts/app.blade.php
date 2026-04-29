<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Ekskul'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-slate-200 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950">

    <div class="min-h-screen flex flex-col">

        <!-- Navbar -->
        <header class="bg-slate-900/70 backdrop-blur border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold tracking-wide">
                    {{ config('app.name', 'Ekskul') }}
                </h1>

                <nav class="space-x-4 text-sm">
                    <a href="#" class="hover:text-white transition">Home</a>
                    <a href="#" class="hover:text-white transition">Kegiatan</a>
                    <a href="#" class="hover:text-white transition">Tentang</a>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-6 py-10">

                <!-- Card Wrapper -->
                <div class="bg-slate-900/60 backdrop-blur rounded-2xl shadow-xl border border-slate-800 p-6">
                    @yield('content')
                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-800 text-center text-sm text-slate-400 py-4">
            © {{ date('Y') }} {{ config('app.name', 'Ekskul') }}. All rights reserved.
        </footer>

    </div>

</body>

</html>