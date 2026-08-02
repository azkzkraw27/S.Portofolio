@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">Web & SEO Settings</h2>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-bold rounded-2xl">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm">

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Grid Line 1: Nama Website & Versi -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Nama Website / Brand -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                        Nama Website / Brand
                    </label>
                    <input type="text" name="site_name" value="{{ old('site_name', \App\Models\Setting::get('site_name', 'SERAYA VISUAL')) }}" required class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                </div>

                <!-- Versi Website -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                        Versi Website / App
                    </label>
                    <input type="text" name="site_version" value="{{ old('site_version', \App\Models\Setting::get('site_version', 'v1.0')) }}" placeholder="Contoh: v1.0" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                </div>
            </div>

            <!-- Title Tab Browser -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                    Title di Atas Browser
                </label>
                <input type="text" name="site_title" value="{{ old('site_title', \App\Models\Setting::get('site_title', 'SERAYA VISUAL - Portfolio & Professional Services')) }}" placeholder="Contoh: SERAYA VISUAL - Official Site" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
            </div>

            <!-- Sub-Judul Halaman Auth / Login -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                    Sub-Judul Halaman Login & Register
                </label>
                <input type="text" name="auth_subtitle" value="{{ old('auth_subtitle', \App\Models\Setting::get('auth_subtitle', 'Selamat datang kembali! Silakan masuk ke akun Anda.')) }}" placeholder="Pesan ucapan di atas form login..." class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
            </div>

            <!-- Meta Deskripsi SEO -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                    Meta Deskripsi (SEO)
                </label>
                <textarea name="meta_description" rows="3" placeholder="Penyedia layanan pengembangan web, desain grafis..." class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">{{ old('meta_description', \App\Models\Setting::get('meta_description', '')) }}</textarea>
            </div>

            <!-- Meta Keywords SEO -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                    Meta Keywords (SEO)
                </label>
                <input type="text" name="meta_keywords" value="{{ old('meta_keywords', \App\Models\Setting::get('meta_keywords', '')) }}" placeholder="web development, desain grafis, portofolio" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
            </div>

            <hr class="border-slate-100 dark:border-slate-700/80">

            <!-- Logo Website -->
            <div class="space-y-3">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                    Logo Website
                </label>
                @php $currentLogo = \App\Models\Setting::get('site_logo'); @endphp
                <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-900/40 rounded-2xl border border-slate-200 dark:border-slate-700/80">
                    <div class="w-16 h-16 rounded-xl border border-slate-200 dark:border-slate-700 p-2 bg-slate-900 flex items-center justify-center shrink-0 shadow-inner">
                        @if($currentLogo)
                            <img src="{{ asset('storage/' . $currentLogo) }}" alt="Logo" class="max-h-full max-w-full object-contain">
                        @else
                            <span class="text-xs text-slate-500 font-bold">No Logo</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $currentLogo ? 'Gambar sedang digunakan' : 'Belum ada logo diunggah' }}
                        </p>
                    </div>
                </div>
                <input type="file" name="site_logo" accept="image/*" class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl p-2">
            </div>

            <!-- Favicon -->
            <div class="space-y-3">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                    Favicon (Ikon Tab Browser)
                </label>
                @php $currentFavicon = \App\Models\Setting::get('site_favicon'); @endphp
                <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-900/40 rounded-2xl border border-slate-200 dark:border-slate-700/80">
                    <div class="w-12 h-12 rounded-xl border border-slate-200 dark:border-slate-700 p-2 bg-slate-900 flex items-center justify-center shrink-0 shadow-inner">
                        @if($currentFavicon)
                            <img src="{{ asset('storage/' . $currentFavicon) }}" alt="Favicon" class="max-h-full max-w-full object-contain">
                        @else
                            <span class="text-[10px] text-slate-500 font-bold">No Icon</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $currentFavicon ? 'Ikon sedang digunakan' : 'Belum ada favicon diunggah' }}
                        </p>
                    </div>
                </div>
                <input type="file" name="site_favicon" accept="image/*,.ico" class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl p-2">
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-500/20 transition cursor-pointer">
                    Simpan Pengaturan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
