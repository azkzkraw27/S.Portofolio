<x-app-layout>
    <x-slot name="header">
        Pengaturan Custom Navbar
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 md:p-8">
            <form action="{{ route('settings.update') }}" method="POST" class="space-y-8">
                @csrf

                <!-- REPEATER MENU NAVBAR -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">📍 Custom Menu Navigasi</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Tambah, ubah, atau hapus item menu navigasi header sesukamu.</p>
                        </div>
                        <button type="button" onclick="addNavRow()" class="px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold text-xs rounded-xl hover:bg-blue-100 transition cursor-pointer">
                            + Tambah Menu
                        </button>
                    </div>

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

                    <div id="nav-items-container" class="space-y-4">
                        @foreach($navMenus as $index => $item)
                            <div class="nav-row p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col md:flex-row items-end gap-3">
                                <div class="w-full md:w-1/3">
                                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nama Menu</label>
                                    <input type="text" name="navbar_menus[{{ $index }}][text]" value="{{ $item['text'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs" required>
                                </div>
                                <div class="w-full md:w-1/3">
                                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">URL / Anchor (#)</label>
                                    <input type="text" name="navbar_menus[{{ $index }}][url]" value="{{ $item['url'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs" required>
                                </div>
                                <div class="w-full md:w-1/4">
                                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Badge (Opsional)</label>
                                    <input type="text" name="navbar_menus[{{ $index }}][badge]" value="{{ $item['badge'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs" placeholder="Misal: New">
                                </div>
                                <button type="button" onclick="this.closest('.nav-row').remove()" class="p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer shrink-0" title="Hapus Menu">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- TOMBOL CTA -->
                <div class="space-y-6 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">🚀 Tombol CTA Kanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Teks Tombol Aksi</label>
                            <input type="text" name="navbar_cta_text" value="{{ \App\Models\Setting::get('navbar_cta_text', 'Start Learning') }}" class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">URL / Target Tautan</label>
                            <input type="text" name="navbar_cta_url" value="{{ \App\Models\Setting::get('navbar_cta_url', '#services') }}" class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-500/30 transition cursor-pointer">
                        Simpan Pengaturan Navbar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JavaScript Tambah Row Dinamis -->
    <script>
        function addNavRow() {
            const container = document.getElementById('nav-items-container');
            const index = Date.now();
            const html = `
                <div class="nav-row p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col md:flex-row items-end gap-3">
                    <div class="w-full md:w-1/3">
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nama Menu</label>
                        <input type="text" name="navbar_menus[${index}][text]" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs" required>
                    </div>
                    <div class="w-full md:w-1/3">
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">URL / Anchor (#)</label>
                        <input type="text" name="navbar_menus[${index}][url]" value="#" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs" required>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Badge (Opsional)</label>
                        <input type="text" name="navbar_menus[${index}][badge]" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs" placeholder="Misal: New">
                    </div>
                    <button type="button" onclick="this.closest('.nav-row').remove()" class="p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer shrink-0" title="Hapus Menu">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }
    </script>
</x-app-layout>
