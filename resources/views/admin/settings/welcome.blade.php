<x-app-layout>
    <x-slot name="header">
        Pengaturan Halaman Utama (Welcome Page)
    </x-slot>

    <div class="max-w-5xl mx-auto pb-12 space-y-8">
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <!-- Flag penanda form halaman utama untuk memproses sakelar enable/disable -->
            <input type="hidden" name="section_form_flag" value="1">

            <!-- SECTION 1: HERO SECTION -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">🚀 Hero Section</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Atur judul utama, deskripsi, gambar hero, dan tombol aksi.</p>
                    </div>
                    <!-- Sakelar Toggle Enable/Disable -->
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_hero" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_hero', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Badge Teks Atas</label>
                        <input type="text" name="hero_badge" value="{{ \App\Models\Setting::get('hero_badge', '✨ PROFESSIONAL CREATIVE & WEB SOLUTIONS') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Gambar Hero Utama</label>
                        <input type="file" name="hero_image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 border border-slate-300 dark:border-slate-700 rounded-xl dark:bg-slate-900" accept="image/*">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Judul Utama Hero</label>
                    <input type="text" name="hero_title" value="{{ \App\Models\Setting::get('hero_title', 'Transform Your Digital Presence & Business.') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs font-bold focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Subdeskripsi Hero</label>
                    <textarea name="hero_subtitle" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs leading-relaxed focus:ring-2 focus:ring-blue-500">{{ \App\Models\Setting::get('hero_subtitle', 'Learn how to build digital products, scale your agency, and land high-paying clients with custom solutions.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tombol 1 (Teks & Link)</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="hero_btn1_text" value="{{ \App\Models\Setting::get('hero_btn1_text', 'Explore Projects') }}" placeholder="Teks Tombol" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            <input type="text" name="hero_btn1_url" value="{{ \App\Models\Setting::get('hero_btn1_url', '#projects') }}" placeholder="Target Link (#)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tombol 2 (Teks & Link)</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="hero_btn2_text" value="{{ \App\Models\Setting::get('hero_btn2_text', 'Read Articles') }}" placeholder="Teks Tombol" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            <input type="text" name="hero_btn2_url" value="{{ \App\Models\Setting::get('hero_btn2_url', '#blog') }}" placeholder="Target Link (#)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Teks Rating / Trust</label>
                        <input type="text" name="hero_trust_text" value="{{ \App\Models\Setting::get('hero_trust_text', 'Trusted by 2,000+ clients & modern brands') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Floating Card Title</label>
                        <input type="text" name="hero_card_title" value="{{ \App\Models\Setting::get('hero_card_title', 'Active Project') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Floating Card Subtitle</label>
                        <input type="text" name="hero_card_subtitle" value="{{ \App\Models\Setting::get('hero_card_subtitle', '100% Client Satisfaction') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                </div>
            </div>

            <!-- SECTION 2: TRUSTED BRANDS -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">🏢 Trusted Brands Section</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Atur teks judul dan daftar nama-nama brand terpercaya.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_trusted" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_trusted', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Judul Teks Brand</label>
                    <input type="text" name="trusted_title" value="{{ \App\Models\Setting::get('trusted_title', 'TRUSTED BY FAST-GROWING BRANDS & CREATORS WORLDWIDE') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Daftar Brand (Pisahkan dengan koma)</label>
                    <input type="text" name="trusted_brands" value="{{ \App\Models\Setting::get('trusted_brands', 'Instagram, TikTok, Shopify, Pinterest, Canva') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                </div>
            </div>

            <!-- SECTION 3: WHAT YOU'LL GET (SERVICES) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">💡 What You'll Get Section</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Atur kartu-kartu penawaran atau layanan utama.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_services" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_services', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Badge Teks</label>
                        <input type="text" name="services_badge" value="{{ \App\Models\Setting::get('services_badge', 'WHAT YOU\'LL GET') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Judul Utama</label>
                        <input type="text" name="services_title" value="{{ \App\Models\Setting::get('services_title', 'Everything you need to scale your digital presence') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                    <!-- Kartu Layanan 1 -->
                    <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 space-y-3">
                        <span class="text-xs font-extrabold text-blue-600 uppercase">Layanan 1</span>
                        <div>
                            <label class="block text-[11px] font-medium text-slate-500 mb-1">Judul Layanan</label>
                            <input type="text" name="service1_title" value="{{ \App\Models\Setting::get('service1_title', 'Custom Web Development') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-slate-500 mb-1">Deskripsi Singkat</label>
                            <textarea name="service1_desc" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs leading-relaxed">{{ \App\Models\Setting::get('service1_desc', 'Build blazing-fast, responsive web apps and business profiles tailored specifically to your unique brand identity.') }}</textarea>
                        </div>
                    </div>

                    <!-- Kartu Layanan 2 -->
                    <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 space-y-3">
                        <span class="text-xs font-extrabold text-blue-600 uppercase">Layanan 2</span>
                        <div>
                            <label class="block text-[11px] font-medium text-slate-500 mb-1">Judul Layanan</label>
                            <input type="text" name="service2_title" value="{{ \App\Models\Setting::get('service2_title', 'UI/UX & Graphic Design') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-slate-500 mb-1">Deskripsi Singkat</label>
                            <textarea name="service2_desc" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs leading-relaxed">{{ \App\Models\Setting::get('service2_desc', 'Create scroll-stopping visuals, brand kits, logos, and intuitive user interfaces that convert visitors into loyal clients.') }}</textarea>
                        </div>
                    </div>

                    <!-- Kartu Layanan 3 -->
                    <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 space-y-3">
                        <span class="text-xs font-extrabold text-blue-600 uppercase">Layanan 3</span>
                        <div>
                            <label class="block text-[11px] font-medium text-slate-500 mb-1">Judul Layanan</label>
                            <input type="text" name="service3_title" value="{{ \App\Models\Setting::get('service3_title', 'Strategy & Digital Growth') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-slate-500 mb-1">Deskripsi Singkat</label>
                            <textarea name="service3_desc" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs leading-relaxed">{{ \App\Models\Setting::get('service3_desc', 'Proven marketing systems, content workflows, and optimization structures designed to scale your business revenue.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: ABOUT / INSTRUCTOR -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">👤 About / Professional Section</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Atur profil perkenalan singkat kamu di halaman depan.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_about" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_about', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Badge Teks</label>
                        <input type="text" name="about_badge" value="{{ \App\Models\Setting::get('about_badge', 'MEET YOUR PROFESSIONAL') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Foto Bio Profil</label>
                        <input type="file" name="about_image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 border border-slate-300 dark:border-slate-700 rounded-xl dark:bg-slate-900" accept="image/*">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Judul Sapaan</label>
                    <input type="text" name="about_title" value="{{ \App\Models\Setting::get('about_title', 'Hi, I\'m ZIKRAW PROJECT! 👋') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi Bio</label>
                    <textarea name="about_desc" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs leading-relaxed">{{ \App\Models\Setting::get('about_desc', 'I help brands, businesses, and creators transition into high-performing digital entities with proven systems, cutting-edge design, and full-stack development.') }}</textarea>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">Fitur 1</label>
                        <input type="text" name="about_feat1" value="{{ \App\Models\Setting::get('about_feat1', 'Full-Stack Developer') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">Fitur 2</label>
                        <input type="text" name="about_feat2" value="{{ \App\Models\Setting::get('about_feat2', 'Thousands of Clients') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">Fitur 3</label>
                        <input type="text" name="about_feat3" value="{{ \App\Models\Setting::get('about_feat3', 'Proven Systems') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">Fitur 4</label>
                        <input type="text" name="about_feat4" value="{{ \App\Models\Setting::get('about_feat4', 'Real-World Experience') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                </div>
            </div>

            <!-- SECTION 5: PROJECTS SHOWCASE (ENABLE / DISABLE TOGGLE) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">🖼️ Section Projects Showcase</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Menampilkan daftar karya portofolio yang diambil otomatis dari menu Projects.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_projects" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_projects', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>
            </div>

            <!-- SECTION 6: PRICING CARD -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">💳 Pricing / Offer Card Section</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Atur kotak penawaran harga & ajakan bertindak (CTA).</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_pricing" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_pricing', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Badge Teks</label>
                        <input type="text" name="pricing_badge" value="{{ \App\Models\Setting::get('pricing_badge', 'INVEST IN YOUR GROWTH') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Judul Penawaran</label>
                        <input type="text" name="pricing_title" value="{{ \App\Models\Setting::get('pricing_title', 'Ready to build your digital future?') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi Penawaran</label>
                    <textarea name="pricing_desc" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs leading-relaxed">{{ \App\Models\Setting::get('pricing_desc', 'Get lifetime access to professional resources, consultation, and end-to-end development services tailored to your needs.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" name="pricing_feat1" value="{{ \App\Models\Setting::get('pricing_feat1', 'Full consultation & strategy') }}" class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    <input type="text" name="pricing_feat2" value="{{ \App\Models\Setting::get('pricing_feat2', 'Premium templates & tools') }}" class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    <input type="text" name="pricing_feat3" value="{{ \App\Models\Setting::get('pricing_feat3', 'Dedicated community support') }}" class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 pt-2">
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">Tag Harga</label>
                        <input type="text" name="pricing_price_tag" value="{{ \App\Models\Setting::get('pricing_price_tag', 'ONE-TIME INVESTMENT') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">Nominal Harga</label>
                        <input type="text" name="pricing_amount" value="{{ \App\Models\Setting::get('pricing_amount', '$297') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">Teks Tombol</label>
                        <input type="text" name="pricing_btn_text" value="{{ \App\Models\Setting::get('pricing_btn_text', 'Get Started Now') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">URL Tombol</label>
                        <input type="text" name="pricing_btn_url" value="{{ \App\Models\Setting::get('pricing_btn_url', '#chat-widget') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-slate-500 mb-1">Garansi / Info</label>
                        <input type="text" name="pricing_guarantee" value="{{ \App\Models\Setting::get('pricing_guarantee', '14-Day Money-Back Guarantee') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                </div>
            </div>

            <!-- SECTION 7: BLOG SHOWCASE (ENABLE / DISABLE TOGGLE) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">📝 Section Blog & Artikel</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Menampilkan daftar artikel terbaru yang dipublikasikan dari menu Blog.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_blog" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_blog', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>
            </div>

            <!-- SECTION 8: FAQs SECTION (TAMBAHAN SAKELAR FAQ) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">❓ FAQs Section</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Menampilkan seksi daftar pertanyaan umum yang dikelola dari menu Kelola FAQ.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_faq" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_faq', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Judul Utama Seksi FAQ</label>
                        <input type="text" name="faq_title" value="{{ \App\Models\Setting::get('faq_title', 'Frequently Asked Questions') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Subdeskripsi Seksi FAQ</label>
                        <input type="text" name="faq_subtitle" value="{{ \App\Models\Setting::get('faq_subtitle', 'Jawaban atas pertanyaan umum seputar layanan dan kerja sama.') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                </div>
            </div>

            <!-- SECTION 9: TESTIMONIALS SECTION -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">💬 Testimonials Section</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Menampilkan seksi testimoni klien yang dikelola dari menu Kelola Testimoni.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_testimonial" value="1" class="sr-only peer" {{ \App\Models\Setting::get('enable_testimonial', '0') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:after:border-slate-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Judul Utama Seksi Testimoni</label>
                        <input type="text" name="testimonial_title" value="{{ \App\Models\Setting::get('testimonial_title', 'What Our Clients Say') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Subdeskripsi Seksi Testimoni</label>
                        <input type="text" name="testimonial_subtitle" value="{{ \App\Models\Setting::get('testimonial_subtitle', 'Ulasan jujur dari para klien yang telah bekerja sama dengan kami.') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-blue-500/30 transition cursor-pointer">
                    Simpan Seluruh Pengaturan Halaman Utama
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
