<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
    $siteSetting = \App\Models\Setting::first();
    // Ambil site_title atau site_name dari DB, jika belum diisi baru fallback ke nama default
    $browserTitle = $siteSetting->site_title ?? $siteSetting->site_name ?? 'SERAYA VISUAL';
@endphp

<!-- Title Khusus Tab Browser Client Area -->
<title>{{ $browserTitle }} - Client Area</title>

    <!-- Dynamic Favicon Client -->
    @if(isset($siteSetting->site_favicon) && $siteSetting->site_favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSetting->site_favicon) }}">
    @endif

    <script>
        // Cek dan terapkan mode gelap dari localStorage / Preferensi Sistem
        function applyUserTheme() {
            if (localStorage.getItem('admin_theme') === 'dark' || (!('admin_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        applyUserTheme();

        function toggleUserDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('admin_theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('admin_theme', 'dark');
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-300">
    <div class="min-h-screen flex">

        <!-- Sidebar Khusus User / Client -->
        <aside class="w-64 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700/80 hidden md:flex flex-col shadow-sm z-10 transition-colors duration-300">
            <!-- Logo Panel -->
            <div class="h-20 flex items-center px-8 border-b border-slate-200 dark:border-slate-700/80">
                <a href="{{ route('user.dashboard') }}" class="text-2xl font-extrabold text-blue-600 dark:text-blue-400 tracking-tight">
                    Client<span class="text-slate-800 dark:text-white">Panel<span class="text-blue-500">.</span></span>
                </a>
            </div>

            <!-- Navigasi Menu Khusus User -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Overview / Dashboard -->
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Overview
                </a>

                <!-- History Chat -->
                <a href="{{ route('user.chat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('user.chat') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    History Chat
                </a>

                <!-- Edit Profile -->
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    User Profile
                </a>
            </nav>

            <div class="p-4 border-t border-slate-200 dark:border-slate-700/80 bg-slate-50 dark:bg-slate-800/50 text-center">
                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500">User Area v1.0</span>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden relative">

            <!-- Header Nav -->
            <header class="h-20 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-700/80 flex items-center justify-between px-8 sticky top-0 z-40 transition-colors duration-300">
                <h2 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight tracking-wide">
                    {{ $header ?? 'Client Area / User Dashboard' }}
                </h2>

                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Tombol Ganti Dark / Light Mode -->
                    <button type="button" onclick="toggleUserDarkMode()" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-700/80 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 transition shadow-sm cursor-pointer" title="Ganti Mode Tampilan">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>

                    <!-- Tombol Lihat Website -->
                    <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/80 hover:bg-blue-50 dark:hover:bg-blue-900/40 text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 text-xs font-bold transition border border-slate-200 dark:border-slate-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <span>Lihat Website</span>
                    </a>

                    <!-- Dropdown User Profil -->
                    <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900/80 py-1.5 px-3 rounded-full border border-slate-200 dark:border-slate-700 hover:border-blue-500 shadow-sm transition cursor-pointer">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-9 w-9 rounded-full object-cover border border-blue-500 shrink-0">
                            @else
                                <div class="h-9 w-9 rounded-full overflow-hidden flex items-center justify-center bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-extrabold shadow-inner shrink-0">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 hidden md:inline-block">{{ Auth::user()->name }}</span>
                        </button>

                        <div x-show="openProfile" @click.outside="openProfile = false" class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60">
                                👤 User Profile
                            </a>
                            <a href="{{ url('/') }}" class="block px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60">
                                🌐 Halaman Utama
                            </a>
                            <div class="border-t border-slate-100 dark:border-slate-700/80 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Area Konten Utama -->
            <main class="flex-1 p-8 relative z-10">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>

        </div>
    </div>
</body>
</html>
