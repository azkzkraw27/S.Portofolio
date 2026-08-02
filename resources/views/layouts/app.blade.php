<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SCRIPT TEMA: Wajib paling atas agar tidak flicker atau ke-reset -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('admin_theme') || localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @php
        $siteName  = \App\Models\Setting::get('site_name', 'SERAYA VISUAL');
        $siteTitle = \App\Models\Setting::get('site_title', $siteName);
        $favicon   = \App\Models\Setting::get('site_favicon');
    @endphp

    <!-- Dynamic Title & Favicon -->
    <title>{{ $siteTitle }} - Admin Panel</title>

    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-300">
    <div class="min-h-screen flex">

        <!-- Sidebar Admin -->
        <aside class="w-64 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700/80 hidden md:flex flex-col shadow-sm z-10 transition-colors duration-300">
            <!-- Logo Admin Panel -->
            <div class="h-20 flex items-center px-8 border-b border-slate-200 dark:border-slate-700/80">
                <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold text-blue-600 dark:text-blue-400 tracking-tight">
                    Admin<span class="text-slate-800 dark:text-white">Panel<span class="text-blue-500">.</span></span>
                </a>
            </div>

            <!-- Navigasi Menu Sidebar -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Overview
                </a>

                <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('projects.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    Projects
                </a>

                <a href="{{ route('posts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('posts.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                    Blog & Artikel
                </a>

                @php
                    $initialUnread = \App\Models\Chat::where('is_read', false)->where('sender_type', 'user')->count();
                @endphp
                <a href="{{ route('chats.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('chats.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
                        Customer Chat
                    </div>
                    <span id="sidebar-unread-badge" class="{{ $initialUnread > 0 ? 'inline-flex' : 'hidden' }} px-2 py-0.5 text-[10px] font-extrabold bg-red-500 text-white rounded-full animate-pulse">
                        {{ $initialUnread }}
                    </span>
                </a>

                <!-- MENU KELOLA FAQ -->
                <a href="{{ route('faqs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('faqs.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Kelola FAQ
                </a>

                <!-- MENU KELOLA TESTIMONI -->
                <a href="{{ route('testimonials.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('testimonials.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                    Kelola Testimoni
                </a>

                <div x-data="{ open: {{ request()->routeIs('settings.welcome') || request()->routeIs('settings.navbar') || request()->routeIs('settings.footer') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ (request()->routeIs('settings.*') && !request()->routeIs('settings.index')) ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }} cursor-pointer">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                            Tampilan
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="h-4 w-4 text-slate-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" x-collapse class="pl-11 pr-2 py-1 space-y-1">
                        <a href="{{ route('settings.welcome') }}" class="block px-3 py-2 text-xs font-bold rounded-lg transition {{ request()->routeIs('settings.welcome') ? 'text-blue-600 dark:text-blue-400 bg-blue-100/50 dark:bg-slate-700' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200' }}">
                            🏠 Halaman Utama
                        </a>
                        <a href="{{ route('settings.navbar') }}" class="block px-3 py-2 text-xs font-bold rounded-lg transition {{ request()->routeIs('settings.navbar') ? 'text-blue-600 dark:text-blue-400 bg-blue-100/50 dark:bg-slate-700' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200' }}">
                            📌 Navbar Header
                        </a>
                        <a href="{{ route('settings.footer') }}" class="block px-3 py-2 text-xs font-bold rounded-lg transition {{ request()->routeIs('settings.footer') ? 'text-blue-600 dark:text-blue-400 bg-blue-100/50 dark:bg-slate-700' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200' }}">
                            🔻 Footer & Medsos
                        </a>
                        <a href="{{ route('settings.auth_appearance') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-xs text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span>Tampilan Login Register</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('settings.index') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800/40' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Web & SEO Settings
                </a>
            </nav>

            <!-- Footer Sidebar Minimalis -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700/80 bg-slate-50 dark:bg-slate-800/50 text-center">
                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500">Admin Panel v1.0</span>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden relative">

            <!-- Navbar / Topbar Admin -->
            <header class="h-20 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-700/80 flex items-center justify-between px-8 sticky top-0 z-40 transition-colors duration-300">
                <h2 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight tracking-wide">
                    {{ $header ?? 'Dashboard' }}
                </h2>

                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Tombol Lihat Website -->
                    <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/80 hover:bg-blue-50 dark:hover:bg-blue-900/40 text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 text-xs font-bold transition border border-slate-200 dark:border-slate-600 shadow-sm" title="Lihat Website Utama">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <span>Lihat Website</span>
                    </a>

                    <!-- Ikon Notifikasi Chat Masuk -->
                    <a href="{{ route('chats.index') }}" class="relative w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700/80 text-slate-600 dark:text-slate-300 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-600 transition cursor-pointer border border-slate-200 dark:border-slate-600 shadow-sm" title="Pesan Customer Masuk">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                        <span id="navbar-unread-badge" class="{{ $initialUnread > 0 ? 'flex' : 'hidden' }} absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white font-black text-[10px] rounded-full items-center justify-center shadow-md animate-pulse">
                            {{ $initialUnread }}
                        </span>
                    </a>

                    <!-- Tombol Sakelar Dark / White Mode -->
                    <button type="button" onclick="event.stopPropagation(); toggleAdminDarkMode();" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700/80 text-slate-600 dark:text-slate-300 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-600 transition cursor-pointer border border-slate-200 dark:border-slate-600 shadow-sm" title="Toggle Theme">
                        <svg id="admin-dark-sun" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <svg id="admin-dark-moon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>

                    <!-- DROPDOWN PROFILE & LOGOUT DI NAVBAR -->
                    <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900/80 py-1.5 px-3 rounded-full border border-slate-200 dark:border-slate-700 hover:border-blue-500 shadow-sm transition cursor-pointer">
                            <div class="h-9 w-9 rounded-full overflow-hidden flex items-center justify-center bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-extrabold shadow-inner shrink-0">
                                @php
                                    $currentUser = auth()->user()->fresh();
                                @endphp
                                @if($currentUser && $currentUser->avatar)
                                    <img src="{{ asset('storage/' . $currentUser->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 hidden md:inline-block">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': openProfile}" class="h-3.5 w-3.5 text-slate-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>

                        <!-- Panel Dropdown Menu -->
                        <div x-show="openProfile" @click.outside="openProfile = false" x-transition.origin.top.right class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-xl py-2 z-50 space-y-1">
                            <!-- Info Singkat User -->
                            <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700/80">
                                <p class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Menu Profile -->
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                User Profile
                            </a>

                            <!-- Menu Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Konten Halaman -->
            <main class="flex-1 p-8 relative z-10">
    @if(isset($slot))
        {{ $slot }}
    @else
        @yield('content')
    @endif
</main>

        </div>
    </div>

    <!-- Script Fungsi Tema & Real-Time Polling Notifikasi Chat -->
    <script>
        function toggleAdminDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('admin_theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('admin_theme', 'dark');
            }
        }

        function checkUnreadChats() {
            fetch("{{ route('admin.chats.unread-count') }}", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                const navBadge = document.getElementById('navbar-unread-badge');
                const sideBadge = document.getElementById('sidebar-unread-badge');
                const count = data.count;

                if (count > 0) {
                    if (navBadge) {
                        navBadge.innerText = count > 9 ? '9+' : count;
                        navBadge.classList.remove('hidden');
                        navBadge.classList.add('flex');
                    }
                    if (sideBadge) {
                        sideBadge.innerText = count;
                        sideBadge.classList.remove('hidden');
                    }
                } else {
                    if (navBadge) {
                        navBadge.classList.remove('flex');
                        navBadge.classList.add('hidden');
                    }
                    if (sideBadge) {
                        sideBadge.classList.add('hidden');
                    }
                }
            })
            .catch(err => console.error("Gagal memeriksa notifikasi chat:", err));
        }

        setInterval(checkUnreadChats, 5000);
    </script>
</body>
</html>
