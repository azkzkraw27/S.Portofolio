<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::get('site_name', 'MyPortfolio') }}</title>
    @if(\App\Models\Setting::get('site_favicon'))
    <link rel="icon" href="{{ asset('storage/' . \App\Models\Setting::get('site_favicon')) }}">
@endif

    <!-- Memanggil TailwindCSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Script deteksi awal Dark Mode agar tidak berkedip putih (FOUC) -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="min-h-screen bg-brand-light dark:bg-brand-dark text-slate-800 dark:text-slate-200 transition-colors duration-300">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 top-0 backdrop-blur-md bg-white/70 dark:bg-brand-dark/80 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
    @if(\App\Models\Setting::get('site_logo'))
        <!-- Menampilkan Logo berupa Gambar dari Settings Admin -->
        <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="{{ \App\Models\Setting::get('site_name', 'MyPortfolio') }}" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
    @else
        <!-- Menampilkan Logo berupa Teks (Fallback jika belum upload logo) -->
        <span class="text-2xl font-bold text-brand-primary dark:text-brand-accent tracking-tight group-hover:scale-105 transition-transform">
            {{ \App\Models\Setting::get('site_name', 'MyPortfolio') }}<span class="text-slate-800 dark:text-white">.</span>
        </span>
    @endif
</a>
                </div>

                <div class="hidden md:flex space-x-8 font-medium">
                    <a href="{{ url('/') }}" class="hover:text-brand-primary transition">Home</a>
                    <a href="#projects" class="hover:text-brand-primary transition">Projects</a>
                    <a href="#pricelist" class="hover:text-brand-primary transition">Pricelist</a>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Tombol Toggle Dark Mode -->
                    <button id="theme-toggle" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                        <svg id="theme-toggle-dark-icon" class="hidden h-6 w-6 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                        <svg id="theme-toggle-light-icon" class="hidden h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </button>

                    <a href="{{ route('login') }}" class="bg-brand-primary hover:bg-blue-800 text-white px-5 py-2 rounded-full font-medium transition shadow-lg shadow-blue-500/30">
                        Client Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-10 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-500 dark:text-slate-400">
            &copy; {{ date('Y') }} MyPortfolio. All rights reserved.
        </div>
    </footer>

    <!-- Script Logika Toggle Dark Mode -->
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        if (document.documentElement.classList.contains('dark')) {
            darkIcon.classList.remove('hidden');
        } else {
            lightIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');

            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
</body>
</html>
