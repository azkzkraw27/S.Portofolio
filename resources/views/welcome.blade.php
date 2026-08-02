<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
    $siteSetting = \App\Models\Setting::first();
    // Ambil site_title atau site_name dari DB, jika belum diisi baru fallback ke nama default
    $browserTitle = $siteSetting->site_title ?? $siteSetting->site_name ?? 'SERAYA VISUAL';
@endphp

<!-- Title Khusus Tab Browser Client Area -->
<title>{{ $browserTitle }}</title>
    <meta name="description" content="{{ $siteSetting->meta_description ?? 'Penyedia layanan pengembangan web, desain grafis, dan solusi digital kreatif profesional.' }}">
    <meta name="keywords" content="{{ $siteSetting->meta_keywords ?? 'web development, desain grafis, portofolio' }}">

    <!-- Dynamic Favicon -->
    @if(isset($siteSetting->site_favicon) && $siteSetting->site_favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSetting->site_favicon) }}">
    @endif

    <!-- Fonts & Tailwind CSS -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 antialiased selection:bg-blue-600 selection:text-white transition-colors duration-300">

    <!-- Floating Pill Navbar Modern -->
    <header class="sticky top-6 z-50 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 rounded-full shadow-xl shadow-slate-200/40 dark:shadow-none px-6 py-2.5 flex items-center justify-between transition-colors duration-300">

            <!-- Sisi Kiri: Logo & Brand Name -->
            <div class="flex items-center gap-3 shrink-0">
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
            </div>

            <!-- Bagian Tengah: Custom Nav Loop -->
            <nav class="hidden lg:flex items-center gap-6 font-semibold text-xs text-slate-600 dark:text-slate-300">
                @php
                    $navMenus = json_decode(\App\Models\Setting::get('navbar_menus', '[]'), true);
                    if(empty($navMenus)) {
                        $navMenus = [
                            ['text' => 'Classes', 'url' => '#services', 'badge' => ''],
                            ['text' => 'Platform', 'url' => '#projects', 'badge' => ''],
                            ['text' => 'Teaching', 'url' => '#about', 'badge' => ''],
                            ['text' => 'Support', 'url' => '#chat-widget', 'badge' => ''],
                            ['text' => 'Atheros Pass', 'url' => '#blog', 'badge' => 'Coming soon!']
                        ];
                    }
                @endphp

                @foreach($navMenus as $menu)
                    <a href="{{ $menu['url'] ?? '#' }}" onclick="if(this.getAttribute('href')=='#chat-widget') toggleChatBox();" class="flex items-center gap-2 hover:text-blue-600 dark:hover:text-blue-400 transition">
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

                <a href="{{ \App\Models\Setting::get('navbar_cta_url', '#services') }}" class="px-5 py-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-md shadow-blue-500/25 transition flex items-center gap-1.5">
                    <span>{{ \App\Models\Setting::get('navbar_cta_text', 'Start Learning') }}</span>
                    <span class="text-xs">🚀</span>
                </a>
            </div>

        </div>
    </header>

    <!-- 1. Hero Section (Controlled by Sakelar Enable/Disable) -->
    @if(\App\Models\Setting::get('enable_hero', '1') == '1')
    <section class="relative pt-12 pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold text-xs uppercase tracking-wider">
                    {{ \App\Models\Setting::get('hero_badge', '✨ PROFESSIONAL CREATIVE & WEB SOLUTIONS') }}
                </span>
                <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1]">
                    {{ \App\Models\Setting::get('hero_title', 'Transform Your Digital Presence & Business.') }}
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    {{ \App\Models\Setting::get('hero_subtitle', 'Learn how to build digital products, scale your agency, and land high-paying clients with custom solutions.') }}
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ \App\Models\Setting::get('hero_btn1_url', '#projects') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-center shadow-xl shadow-blue-600/30 transition transform hover:-translate-y-0.5">
                        {{ \App\Models\Setting::get('hero_btn1_text', 'Explore Projects') }}
                    </a>
                    <a href="{{ \App\Models\Setting::get('hero_btn2_url', '#blog') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-bold text-center transition">
                        {{ \App\Models\Setting::get('hero_btn2_text', 'Read Articles') }}
                    </a>
                </div>

                <!-- Trust Badge -->
                <div class="flex items-center justify-center lg:justify-start gap-3 pt-4">
                    <div class="flex -space-x-2">
                        <span class="w-7 h-7 rounded-full bg-blue-500 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white dark:border-slate-900">JD</span>
                        <span class="w-7 h-7 rounded-full bg-indigo-500 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white dark:border-slate-900">AS</span>
                        <span class="w-7 h-7 rounded-full bg-sky-500 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white dark:border-slate-900">MK</span>
                    </div>
                    <div class="text-left">
                        <p class="text-amber-400 text-xs">★★★★★</p>
                        <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">{{ \App\Models\Setting::get('hero_trust_text', 'Trusted by 2,000+ clients & modern brands') }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="w-full h-[420px] bg-gradient-to-tr from-blue-600 to-sky-400 rounded-[2.5rem] shadow-2xl flex items-center justify-center overflow-hidden relative">
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ \App\Models\Setting::get('hero_image') ? asset('storage/' . \App\Models\Setting::get('hero_image')) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=800' }}');"></div>
                    </div>

                    <!-- Floating Card -->
                    <div class="absolute -bottom-6 -left-6 bg-white/95 dark:bg-slate-800/95 backdrop-blur-md p-4 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-2xl flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/40 flex items-center justify-center text-lg">🚀</div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ \App\Models\Setting::get('hero_card_title', 'Active Project') }}</p>
                            <p class="text-xs font-extrabold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('hero_card_subtitle', '100% Client Satisfaction') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    @endif

    <!-- 2. Trusted Brands Section -->
    @if(\App\Models\Setting::get('enable_trusted', '1') == '1')
    <section class="py-10 border-y border-slate-100 dark:border-slate-800/80 bg-white/50 dark:bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-6 text-center space-y-6">
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ \App\Models\Setting::get('trusted_title', 'TRUSTED BY FAST-GROWING BRANDS & CREATORS WORLDWIDE') }}</p>
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-16 font-extrabold text-slate-400 dark:text-slate-500 text-lg">
                @foreach(explode(',', \App\Models\Setting::get('trusted_brands', 'Instagram, TikTok, Shopify, Pinterest, Canva')) as $brand)
                    <span>{{ trim($brand) }}</span>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 3. What You'll Get / Services Section -->
    @if(\App\Models\Setting::get('enable_services', '1') == '1')
    <section id="services" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">{{ \App\Models\Setting::get('services_badge', 'WHAT YOU\'LL GET') }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('services_title', 'Everything you need to scale your digital presence') }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-xl space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center text-xl">🚀</div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('service1_title', 'Custom Web Development') }}</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">{{ \App\Models\Setting::get('service1_desc', 'Build blazing-fast, responsive web apps and business profiles tailored specifically to your unique brand identity.') }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-xl space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center text-xl">🎨</div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('service2_title', 'UI/UX & Graphic Design') }}</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">{{ \App\Models\Setting::get('service2_desc', 'Create scroll-stopping visuals, brand kits, logos, and intuitive user interfaces that convert visitors into loyal clients.') }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-xl space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center text-xl">📈</div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('service3_title', 'Strategy & Digital Growth') }}</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">{{ \App\Models\Setting::get('service3_desc', 'Proven marketing systems, content workflows, and optimization structures designed to scale your business revenue.') }}</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 4. About Section -->
    @if(\App\Models\Setting::get('enable_about', '1') == '1')
    <section id="about" class="py-20 bg-blue-600 text-white my-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-5">
                <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white/20 h-80 bg-cover bg-center" style="background-image: url('{{ \App\Models\Setting::get('about_image') ? asset('storage/' . \App\Models\Setting::get('about_image')) : 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=800' }}');"></div>
            </div>
            <div class="lg:col-span-7 space-y-6">
                <span class="px-4 py-1.5 rounded-full bg-blue-500 text-white font-bold text-xs uppercase tracking-wider">{{ \App\Models\Setting::get('about_badge', 'MEET YOUR PROFESSIONAL') }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ \App\Models\Setting::get('about_title', 'Hi, I\'m ZIKRAW PROJECT! 👋') }}</h2>
                <p class="text-blue-100 text-base leading-relaxed">
                    {{ \App\Models\Setting::get('about_desc', 'I help brands, businesses, and creators transition into high-performing digital entities with proven systems, cutting-edge design, and full-stack development.') }}
                </p>
                <div class="grid grid-cols-2 gap-4 pt-2 font-bold text-sm">
                    <p>✓ {{ \App\Models\Setting::get('about_feat1', 'Full-Stack Developer') }}</p>
                    <p>✓ {{ \App\Models\Setting::get('about_feat2', 'Thousands of Clients') }}</p>
                    <p>✓ {{ \App\Models\Setting::get('about_feat3', 'Proven Systems') }}</p>
                    <p>✓ {{ \App\Models\Setting::get('about_feat4', 'Real-World Experience') }}</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 5. Dynamic Projects Showcase Section -->
    @if(\App\Models\Setting::get('enable_projects', '1') == '1')
    <section id="projects" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Portfolio Showcase</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Featured Creative Projects</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse ($projects as $project)
                    <div class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden border border-slate-100 dark:border-slate-700 shadow-xl flex flex-col group">
                        <div class="h-56 bg-slate-100 dark:bg-slate-700 relative overflow-hidden">
                            @if($project->image_path)
                                <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs font-bold">No Image</div>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-1 justify-between space-y-4">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ $project->title }}</h3>
                                <p class="text-slate-600 dark:text-slate-300 text-sm line-clamp-2">{{ $project->description }}</p>
                            </div>
                            @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                    Live Preview →
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-400">Belum ada project yang dipublikasikan.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- 6. Pricing / Offer Card Section -->
    @if(\App\Models\Setting::get('enable_pricing', '1') == '1')
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-8 md:p-12 border border-slate-100 dark:border-slate-700 shadow-2xl grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-7 space-y-4">
                    <span class="px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 font-bold text-[10px] uppercase tracking-wider">{{ \App\Models\Setting::get('pricing_badge', 'INVEST IN YOUR GROWTH') }}</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('pricing_title', 'Ready to build your digital future?') }}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ \App\Models\Setting::get('pricing_desc', 'Get lifetime access to professional resources, consultation, and end-to-end development services tailored to your needs.') }}</p>
                    <div class="space-y-2 text-xs font-bold text-slate-700 dark:text-slate-300">
                        <p>✓ {{ \App\Models\Setting::get('pricing_feat1', 'Full consultation & strategy') }}</p>
                        <p>✓ {{ \App\Models\Setting::get('pricing_feat2', 'Premium templates & tools') }}</p>
                        <p>✓ {{ \App\Models\Setting::get('pricing_feat3', 'Dedicated community support') }}</p>
                    </div>
                </div>
                <div class="md:col-span-5 bg-slate-50 dark:bg-slate-900/60 p-6 rounded-3xl border border-slate-200/60 dark:border-slate-700 text-center space-y-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ \App\Models\Setting::get('pricing_price_tag', 'ONE-TIME INVESTMENT') }}</p>
                    <p class="text-4xl font-extrabold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('pricing_amount', '$297') }}</p>
                    <a href="{{ \App\Models\Setting::get('pricing_btn_url', '#chat-widget') }}" onclick="if(this.getAttribute('href')=='#chat-widget') toggleChatBox();" class="block w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 transition cursor-pointer">
                        {{ \App\Models\Setting::get('pricing_btn_text', 'Get Started Now') }}
                    </a>
                    <p class="text-[10px] text-slate-400 font-medium">🛡️ {{ \App\Models\Setting::get('pricing_guarantee', '14-Day Money-Back Guarantee') }}</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- SEKSI FAQs -->
@if(\App\Models\Setting::get('enable_faq', '1') == '1' && isset($faqs) && $faqs->count() > 0)
<section class="py-20 bg-slate-50 dark:bg-slate-900/50">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ \App\Models\Setting::get('faq_title', 'Frequently Asked Questions') }}</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">{{ \App\Models\Setting::get('faq_subtitle', 'Jawaban atas pertanyaan umum seputar layanan dan kerja sama.') }}</p>
        </div>

        <div class="space-y-4" x-data="{ activeFaq: null }">
            @foreach($faqs as $index => $faq)
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700/80 overflow-hidden shadow-sm transition">
                    <button @click="activeFaq = (activeFaq === {{ $index }} ? null : {{ $index }})" class="w-full flex justify-between items-center p-6 text-left font-bold text-slate-800 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 transition cursor-pointer">
                        <span>{{ $faq->question }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': activeFaq === {{ $index }}}" class="h-5 w-5 text-slate-400 transition-transform duration-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="activeFaq === {{ $index }}" x-collapse class="px-6 pb-6 text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-700/60 pt-4">
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- SEKSI TESTIMONIALS -->
@if(\App\Models\Setting::get('enable_testimonial', '0') == '1' && isset($testimonials) && $testimonials->count() > 0)
<section class="py-20 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ \App\Models\Setting::get('testimonial_title', 'What Our Clients Say') }}</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">{{ \App\Models\Setting::get('testimonial_subtitle', 'Ulasan jujur dari para klien yang telah bekerja sama dengan kami.') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $item)
                <div class="bg-slate-50 dark:bg-slate-800/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="text-amber-400 text-sm">
                            {{ str_repeat('★', $item->rating) }}
                        </div>
                        <p class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed italic">
                            "{{ $item->quote }}"
                        </p>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-200/60 dark:border-slate-700/60">
                        @if($item->avatar)
                            <img src="{{ asset('storage/' . $item->avatar) }}" alt="{{ $item->client_name }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold text-sm flex items-center justify-center shrink-0">
                                {{ substr($item->client_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white">{{ $item->client_name }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item->client_title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

    <!-- 7. Dynamic Blog Section -->
    @if(\App\Models\Setting::get('enable_blog', '1') == '1')
    <section id="blog" class="py-20 bg-slate-100/50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Insights & Articles</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Latest Blog Posts</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse ($posts as $post)
                    <div class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden border border-slate-100 dark:border-slate-700 shadow-xl flex flex-col group">
                        <div class="h-48 bg-slate-100 dark:bg-slate-700 relative overflow-hidden">
                            @if($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">No Image</div>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-1 justify-between space-y-4">
                            <div>
                                <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">{{ $post->category }}</span>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mt-2 mb-2 line-clamp-2">{{ $post->title }}</h3>
                                <p class="text-slate-600 dark:text-slate-300 text-sm line-clamp-3">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1 text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">Read Article →</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-400">Belum ada artikel blog.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- Footer Dinamis -->
    <footer class="w-full bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 text-slate-500 dark:text-slate-400 py-12 px-6 sm:px-12 transition-colors duration-300">
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

    <!-- Floating Chat Widget -->
    <div id="chat-widget" class="fixed bottom-6 right-6 z-[9999]">
        <button type="button" onclick="toggleChatBox()" class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-2xl flex items-center justify-center transition-transform hover:scale-110 focus:outline-none cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
        </button>

        <div id="chat-box" class="hidden absolute bottom-20 right-0 w-80 sm:w-96 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col transition-all duration-300 z-[9999]">
            <div class="bg-blue-600 p-4 text-white flex justify-between items-center">
                <div>
                    <h4 class="font-bold text-base">Live Chat Klien</h4>
                    <p class="text-xs text-blue-100">Terhubung langsung dengan Admin.</p>
                </div>
                <button type="button" onclick="toggleChatBox()" class="text-white font-bold text-lg px-2 cursor-pointer">×</button>
            </div>

            <!-- Container Pesan -->
            <div class="p-4 flex flex-col h-80 overflow-y-auto space-y-3 bg-slate-50 dark:bg-slate-900/50 text-sm" id="public-chat-messages">
                <div class="bg-white dark:bg-slate-700 p-3 rounded-2xl rounded-tl-none shadow-sm text-slate-700 dark:text-slate-200 text-xs">
                    Halo! Ada yang bisa kami bantu seputar project atau layanan? Silakan tulis pesan Anda di bawah.
                </div>
            </div>

            <!-- Form Kirim Pesan -->
            <form id="public-chat-form" onsubmit="sendPublicMessage(event)" class="p-3 bg-white dark:bg-slate-800 border-t border-slate-100 dark:border-slate-700 space-y-2">
                @csrf
                <input type="text" id="chat-name" placeholder="Nama Anda" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
                <input type="email" id="chat-email" placeholder="Email Anda" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
                <div class="flex gap-2">
                    <input type="text" id="chat-msg" placeholder="Tulis pesan..." class="flex-1 px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
                    <button type="submit" id="chat-send-btn" class="bg-blue-600 text-white px-4 py-2 text-xs font-bold rounded-lg hover:bg-blue-700 transition cursor-pointer">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts Global & Real-time Chat AJAX -->
    <script>
    // Dark Mode Setup
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

    let chatInterval = null;

    function toggleChatBox() {
        const box = document.getElementById('chat-box');
        box.classList.toggle('hidden');

        if (!box.classList.contains('hidden')) {
            // Muat data profil dari LocalStorage jika ada
            const savedName = localStorage.getItem('chat_user_name');
            const savedEmail = localStorage.getItem('chat_user_email');
            if (savedName) document.getElementById('chat-name').value = savedName;
            if (savedEmail) {
                document.getElementById('chat-email').value = savedEmail;
                fetchPublicMessages(); // Ambil riwayat percakapan
            }

            // PERBAIKAN: Menggunakan variabel chatInterval yang benar
            if (!chatInterval) {
                chatInterval = setInterval(fetchPublicMessages, 3000);
            }
        } else {
            if (chatInterval) {
                clearInterval(chatInterval);
                chatInterval = null;
            }
        }
    }

    // PERBAIKAN: Mengirim key `sender_name` & `sender_email` sesuai Controller & Model Chat kamu
    function sendPublicMessage(e) {
        e.preventDefault();

        const name = document.getElementById('chat-name').value;
        const email = document.getElementById('chat-email').value;
        const message = document.getElementById('chat-msg').value;
        const btn = document.getElementById('chat-send-btn');

        if (!message.trim()) return;

        // Simpan identitas pengguna di LocalStorage
        localStorage.setItem('chat_user_name', name);
        localStorage.setItem('chat_user_email', email);

        btn.disabled = true;
        btn.innerText = '...';

        // Sesuaikan key FormData dengan Controller & Model kamu
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('sender_name', name);
        formData.append('sender_email', email);
        formData.append('message', message);

        fetch("{{ route('chat.store') }}", {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('chat-msg').value = '';
            btn.disabled = false;
            btn.innerText = 'Kirim';
            fetchPublicMessages(); // Refresh obrolan
        })
        .catch(err => {
            console.error("Gagal mengirim pesan:", err);
            btn.disabled = false;
            btn.innerText = 'Kirim';
        });
    }

    // PERBAIKAN: Membaca kolom `sender_type === 'admin'` dari Controller kamu
    function fetchPublicMessages() {
        const email = document.getElementById('chat-email').value || localStorage.getItem('chat_user_email');
        if (!email) return;

        fetch(`/chat/messages/${encodeURIComponent(email)}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => res.json())
        .then(messages => {
            const container = document.getElementById('public-chat-messages');
            let html = `
                <div class="bg-white dark:bg-slate-700 p-3 rounded-2xl rounded-tl-none shadow-sm text-slate-700 dark:text-slate-200 text-xs">
                    Halo! Ada yang bisa kami bantu seputar project atau layanan? Silakan tulis pesan Anda di bawah.
                </div>
            `;

            messages.forEach(msg => {
                // Pengecekan sender_type === 'admin'
                const isAdmin = msg.sender_type === 'admin' || msg.is_admin == 1;

                if (isAdmin) {
                    // Pesan Balasan dari Admin (Rata Kiri)
                    html += `
                        <div class="bg-blue-100 dark:bg-blue-900/60 p-3 rounded-2xl rounded-tl-none text-slate-800 dark:text-blue-100 text-xs shadow-sm max-w-[85%] self-start">
                            <span class="font-bold block text-[10px] text-blue-600 dark:text-blue-300 mb-1">${msg.sender_name || 'Admin'}</span>
                            ${msg.message}
                        </div>
                    `;
                } else {
                    // Pesan dari Pengunjung (Rata Kanan)
                    html += `
                        <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none text-xs shadow-sm max-w-[85%] self-end">
                            ${msg.message}
                        </div>
                    `;
                }
            });

            container.innerHTML = html;
            container.scrollTop = container.scrollHeight; // Auto scroll ke paling bawah
        })
        .catch(err => console.error("Gagal mengambil pesan:", err));
    }
</script>
</body>
</html>
