<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Dynamic Title & SEO Meta -->
    <title>{{ $post->title }} - {{ \App\Models\Setting::get('site_name', 'ZIKRAW PROJECT') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($post->content), 150) }}">
    <meta name="keywords" content="{{ $post->category }}, {{ \App\Models\Setting::get('meta_keywords', 'blog, article') }}">

    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon" href="{{ asset('storage/' . \App\Models\Setting::get('site_favicon')) }}">
    @endif

    <!-- Fonts & Tailwind CSS -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 antialiased selection:bg-blue-600 selection:text-white transition-colors duration-300 flex flex-col min-h-screen">

    <!-- 1. Floating Pill Navbar (Persis Welcome Page) -->
    <header class="sticky top-6 z-50 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 rounded-full shadow-xl shadow-slate-200/40 dark:shadow-none px-6 py-2.5 flex items-center justify-between transition-colors duration-300">

            <!-- Sisi Kiri: Logo & Brand Name -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
                @if(\App\Models\Setting::get('site_logo'))
                    <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Logo" class="h-8 w-auto max-w-[100px] object-contain">
                @else
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-extrabold text-sm shadow-sm">
                        {{ substr(\App\Models\Setting::get('site_name', 'Z'), 0, 1) }}
                    </div>
                @endif
                <span class="font-extrabold text-base text-slate-900 dark:text-white tracking-tight leading-none hidden sm:inline-block">
                    {{ \App\Models\Setting::get('site_name', 'ZIKRAW PROJECT') }}
                </span>
            </a>

            <!-- Bagian Tengah: Navigasi Loop Dinamis -->
            <nav class="hidden lg:flex items-center gap-6 font-semibold text-xs text-slate-600 dark:text-slate-300">
                @php
                    $navMenus = json_decode(\App\Models\Setting::get('navbar_menus', '[]'), true);
                    if(empty($navMenus)) {
                        $navMenus = [
                            ['text' => 'Classes', 'url' => url('/') . '#services', 'badge' => ''],
                            ['text' => 'Platform', 'url' => url('/') . '#projects', 'badge' => ''],
                            ['text' => 'Teaching', 'url' => url('/') . '#about', 'badge' => ''],
                            ['text' => 'Support', 'url' => url('/') . '#chat-widget', 'badge' => ''],
                            ['text' => 'Atheros Pass', 'url' => url('/') . '#blog', 'badge' => 'Coming soon!']
                        ];
                    }
                @endphp

                @foreach($navMenus as $menu)
                    <a href="{{ Str::startsWith($menu['url'] ?? '#', '#') ? url('/') . $menu['url'] : ($menu['url'] ?? '#') }}" class="flex items-center gap-2 hover:text-blue-600 dark:hover:text-blue-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        {{ $menu['text'] }}

                        @if(!empty($menu['badge']))
                            <span class="px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 text-[10px] font-bold">
                                {{ $menu['badge'] }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <!-- Sisi Kanan: Dark Mode & Dynamic CTA Button -->
            <div class="flex items-center gap-3 shrink-0">
                <button type="button" onclick="toggleDarkMode()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition cursor-pointer" title="Toggle Dark Mode">
                    <svg id="dark-icon-sun" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg id="dark-icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>

                @auth
                    <a href="{{ url('/dashboard') }}" class="text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-blue-600 transition px-2">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-blue-600 transition px-2 hidden sm:inline-block">Log In</a>
                @endauth

                <a href="{{ Str::startsWith(\App\Models\Setting::get('navbar_cta_url', '#services'), '#') ? url('/') . \App\Models\Setting::get('navbar_cta_url', '#services') : \App\Models\Setting::get('navbar_cta_url', '#services') }}" class="px-5 py-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-md shadow-blue-500/25 transition flex items-center gap-1.5">
                    <span>{{ \App\Models\Setting::get('navbar_cta_text', 'Start Learning') }}</span>
                    <span class="text-xs">🚀</span>
                </a>
            </div>

        </div>
    </header>

    <!-- 2. Konten Artikel Blog -->
    <main class="flex-1 py-12 md:py-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center space-y-4">
            <span class="px-4 py-1.5 bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 rounded-full text-xs font-bold uppercase tracking-wider">
                {{ $post->category }}
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight">
                {{ $post->title }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium">
                Dipublikasikan pada {{ $post->created_at->format('d M Y') }}
            </p>
        </div>

        @if($post->image_path)
            <div class="mb-10 rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 dark:border-slate-800">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-auto max-h-[500px] object-cover">
            </div>
        @endif

        <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 text-base sm:text-lg leading-relaxed space-y-6 bg-white dark:bg-slate-800 p-8 md:p-12 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl">
            {!! nl2br(e($post->content)) !!}
        </div>

        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center">
            <a href="{{ url('/') }}#blog" class="px-6 py-3 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs hover:bg-slate-50 dark:hover:bg-slate-700 transition inline-flex items-center gap-2">
                ← Kembali ke Beranda & Blog
            </a>
        </div>
    </main>

    <!-- 3. Footer Dinamis (Persis Welcome Page) -->
    <footer class="w-full bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 text-slate-500 dark:text-slate-400 py-12 px-6 sm:px-12 transition-colors duration-300 mt-auto">
        <div class="max-w-6xl mx-auto space-y-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start justify-between">
                <div class="md:col-span-4 space-y-3">
                    <div class="flex items-center gap-3">
                        @if(\App\Models\Setting::get('site_logo'))
                            <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Logo" class="h-8 w-auto max-w-[100px] object-contain shrink-0">
                        @else
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-extrabold text-sm shrink-0">
                                {{ substr(\App\Models\Setting::get('site_name', 'Z'), 0, 1) }}
                            </div>
                        @endif
                        <span class="font-extrabold text-lg text-slate-900 dark:text-white tracking-tight">{{ \App\Models\Setting::get('site_name', 'ZIKRAW PROJECT') }}</span>
                    </div>
                    <p class="text-[12px] leading-relaxed text-slate-400 dark:text-slate-400 max-w-xs">
                        {{ \App\Models\Setting::get('footer_description', 'Streamline your business financial management with our intuitive, scalable platform.') }}
                    </p>
                </div>

                <div class="md:col-span-2 space-y-3 md:pl-4">
                    <h4 class="text-[12px] font-bold text-slate-900 dark:text-white">Useful Link</h4>
                    <ul class="space-y-2 text-[12px]">
                        <li><a href="{{ \App\Models\Setting::get('footer_link1_url', '#') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">{{ \App\Models\Setting::get('footer_link1_text', 'Home') }}</a></li>
                        <li><a href="{{ \App\Models\Setting::get('footer_link2_url', '#services') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">{{ \App\Models\Setting::get('footer_link2_text', 'Features') }}</a></li>
                        <li><a href="{{ \App\Models\Setting::get('footer_link3_url', '#projects') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">{{ \App\Models\Setting::get('footer_link3_text', 'Pricing') }}</a></li>
                        <li><a href="{{ \App\Models\Setting::get('footer_link4_url', '#chat-widget') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">{{ \App\Models\Setting::get('footer_link4_text', 'Contact') }}</a></li>
                    </ul>
                </div>

                <div class="md:col-span-2 space-y-3">
                    <h4 class="text-[12px] font-bold text-slate-900 dark:text-white">Follow Us</h4>
                    <ul class="space-y-2 text-[12px]">
                        <li><a href="{{ \App\Models\Setting::get('footer_facebook', '#') }}" target="_blank" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Facebook</a></li>
                        <li><a href="{{ \App\Models\Setting::get('footer_instagram', '#') }}" target="_blank" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Instagram</a></li>
                        <li><a href="{{ \App\Models\Setting::get('footer_twitter', '#') }}" target="_blank" class="hover:text-blue-600 dark:hover:text-blue-400 transition">X (Twitter)</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4 space-y-3">
                    <h4 class="text-[12px] font-bold text-slate-900 dark:text-white">Subscribe our newsletter</h4>
                    <form onsubmit="event.preventDefault(); alert('Terima kasih telah berlangganan!');" class="flex items-center bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 rounded-full p-1.5 shadow-sm">
                        <input type="email" placeholder="Your email address" class="w-full px-4 py-1.5 text-[12px] bg-transparent text-slate-800 dark:text-white placeholder-slate-400 border-none outline-none focus:outline-none focus:ring-0" required>
                        <button type="submit" class="px-5 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[12px] transition cursor-pointer shrink-0 shadow-md shadow-blue-500/20">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-[11px] text-slate-400">
                <p>{{ \App\Models\Setting::get('footer_copyright', 'Copyright © ' . date('Y') . ' ZIKRAW PROJECT') }}</p>
                <p>All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts Dark Mode -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</body>
</html>
