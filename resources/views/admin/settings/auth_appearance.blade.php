@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">Pengaturan Tampilan Login & Register</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Unggah file GIF atau gambar animasi untuk menghiasi halaman autentikasi.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-bold rounded-2xl">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm space-y-6">
        <form action="{{ route('settings.update_auth_appearance') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @php
                // Ambil file path GIF dari Key-Value DB
                $currentAuthBg = \App\Models\Setting::get('auth_bg');
            @endphp

            <!-- Preview GIF Saat Ini -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">GIF / Gambar Saat Ini</label>
                <div class="w-full max-w-xs h-80 rounded-3xl overflow-hidden border-2 border-slate-200 dark:border-slate-700 bg-slate-900 flex items-center justify-center relative shadow-lg">
                    @if($currentAuthBg)
                        <img src="{{ asset('storage/' . $currentAuthBg) }}" alt="Auth GIF" class="w-full h-full object-cover">
                    @else
                        <div class="text-center p-4">
                            <span class="text-4xl">🎬</span>
                            <p class="text-xs text-slate-400 mt-2">Belum ada GIF yang diunggah. Tampilan akan menggunakan default.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Input Upload File -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Pilih File GIF Baru (Format: GIF, PNG, WEBP, JPG. Maks: 10MB)</label>
                <input type="file" name="auth_bg" accept="image/gif,image/png,image/jpeg,image/webp" required class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl p-2">
                @error('auth_bg')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-500/20 transition cursor-pointer">
                    Simpan & Terapkan GIF
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
