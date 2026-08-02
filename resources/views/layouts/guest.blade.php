<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        // Menggunakan helper Setting::get() sesuai pola Key-Value
        $siteName     = \App\Models\Setting::get('site_name', 'SERAYA VISUAL');
        $siteTitle    = \App\Models\Setting::get('site_title', $siteName);
        $appVersion   = \App\Models\Setting::get('site_version', 'v1.0');
        $authSubtitle = \App\Models\Setting::get('auth_subtitle', 'Selamat datang kembali! Silakan masuk ke akun Anda.');

        $authBg = \App\Models\Setting::get('auth_bg');
        $authBgUrl = $authBg
            ? asset('storage/' . $authBg)
            : 'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExM3Z2eHkxdTlyN2V4ZHFydnZ3eXZ1eXNmZXRhOHk4dW43eWZveSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/3oKIPa2TdahY8LAA2Q/giphy.gif';

        $siteLogo = \App\Models\Setting::get('site_logo');
        $favicon  = \App\Models\Setting::get('site_favicon');
    @endphp

    <!-- Dynamic Browser Tab Title -->
    <title>{{ $siteTitle }} - Authentication</title>

    <!-- Dynamic Favicon -->
    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-[#0d0d0d] text-white min-h-screen flex items-center justify-center p-4 md:p-8">

    <!-- Container Utama Split Screen Card -->
    <div class="w-full max-w-5xl bg-[#141414] border border-white/10 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[600px]">

        <!-- Kolom Kiri: Kartu GIF Animated -->
        <div class="w-full md:w-1/2 p-6 md:p-8 flex items-center justify-center bg-black/40">
            <div class="relative w-full h-[380px] md:h-[500px] rounded-2xl overflow-hidden shadow-2xl border border-white/10 group">
                <img src="{{ $authBgUrl }}" alt="Auth Animation" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

                <!-- Overlay Gradasi Gelap -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                <!-- Teks Nama Website & Versi di Atas GIF -->
                <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between text-white">
                    <div class="flex flex-col">
                        <span class="font-extrabold text-sm md:text-base tracking-wide">{{ $siteName }}</span>
                        <span class="text-[11px] text-slate-300 font-medium">{{ $appVersion }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Auth (Login / Register) -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">

            <!-- Logo / Title di Atas Form Login -->
            <div class="mb-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    @if($siteLogo)
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="h-8 w-auto object-contain">
                    @else
                        <span class="text-2xl font-extrabold text-blue-500 tracking-tight">
                            {{ $siteName }}<span class="text-white">.</span>
                        </span>
                    @endif
                </a>

                <!-- Sub-judul Dinamis dari Setting Admin -->
                <p class="text-xs text-slate-400 mt-2">{{ $authSubtitle }}</p>
            </div>

            <!-- Isi Form Login/Register -->
            {{ $slot }}
        </div>

    </div>
</body>
</html>
