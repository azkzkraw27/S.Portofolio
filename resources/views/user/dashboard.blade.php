@extends('layouts.user')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8 pb-12">
        <!-- Banner Kartu Selamat Datang -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl shadow-blue-500/10">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[11px] font-extrabold uppercase tracking-wider">
                        Client Workspace
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold">
                        Selamat Datang, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-blue-100 text-xs md:text-sm max-w-xl leading-relaxed">
                        Kelola akun Anda, lihat riwayat interaksi, atau hubungi tim support kami jika membutuhkan bantuan proyek dan layanan.
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ url('/') }}" class="px-5 py-3 bg-white hover:bg-slate-100 text-blue-700 font-bold text-xs rounded-2xl shadow-md transition-all">
                        🌐 Halaman Utama
                    </a>
                </div>
            </div>
            <!-- Elemen Dekorasi Background -->
            <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        @if(session('error'))
            <div class="p-4 bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 text-xs font-bold rounded-2xl">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <!-- Grid Ringkasan & Fitur Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Ringkasan Status Akun -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                    👤
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Akun</h3>
                    <p class="text-lg font-bold text-slate-900 dark:text-white capitalize mt-0.5">
                        {{ auth()->user()->role ?? 'Client Member' }}
                    </p>
                </div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                    Terverifikasi sebagai pengguna aktif platform.
                </p>
            </div>

            <!-- Email Terdaftar -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                    📧
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email Akun</h3>
                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate mt-0.5">
                        {{ auth()->user()->email }}
                    </p>
                </div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                    Gunakan email ini saat berkonsultasi via Customer Chat.
                </p>
            </div>

            <!-- Pengaturan Profil -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                        ⚙️
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Pengaturan Profil</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Ubah foto profil, nama, atau kata sandi akun Anda.
                    </p>
                </div>
                <a href="{{ route('profile.edit') }}" class="inline-flex justify-center py-2.5 px-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 font-bold text-xs rounded-xl transition">
                    Edit Profil Saya →
                </a>
            </div>
        </div>

        <!-- Tabel / Riwayat Chat dengan Support Admin -->
        <div id="pesan-konsultasi" class="bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        💬 Pesan & Konsultasi Saya
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Riwayat percakapan Anda dengan tim admin kami.
                    </p>
                </div>
            </div>

            @if(!isset($myChats) || $myChats->isEmpty())
                <div class="text-center py-12 space-y-3">
                    <div class="text-4xl">📨</div>
                    <p class="text-xs text-slate-400 font-medium">Belum ada riwayat pesan yang Anda kirimkan.</p>
                    <a href="{{ url('/#chat-widget') }}" class="inline-block px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition">
                        Kirim Pesan Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($myChats as $chat)
                        <div class="p-4 rounded-2xl border border-slate-100 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/40 flex items-start justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-md {{ $chat->sender_type == 'admin' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400' : 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300' }}">
                                        {{ $chat->sender_type == 'admin' ? 'Tim Admin' : 'Saya' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">
                                        {{ $chat->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-800 dark:text-slate-200 leading-relaxed">
                                    {{ $chat->message }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
