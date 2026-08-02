<x-app-layout>
    <x-slot name="header">
        Pengaturan Footer Website
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 md:p-8">
            <form action="{{ route('settings.update') }}" method="POST" class="space-y-8">
                @csrf

                <!-- SECTION 1: DESKRIPSI & COPYRIGHT -->
                <div class="space-y-6">
                    <div class="border-b border-slate-100 dark:border-slate-700 pb-4">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">🔻 Konten Utama & Copyright</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Atur deskripsi singkat dan teks hak cipta di bagian bawah footer.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi Singkat Footer</label>
                        <textarea name="footer_description" rows="3" class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:border-blue-600 focus:ring-blue-600">{{ \App\Models\Setting::get('footer_description', 'Streamline your business financial management with our intuitive, scalable platform.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Teks Copyright Footer</label>
                        <input type="text" name="footer_copyright" value="{{ \App\Models\Setting::get('footer_copyright', 'Copyright © ' . date('Y') . ' ZIKRAW PROJECT') }}" class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:border-blue-600 focus:ring-blue-600" placeholder="Contoh: Copyright © 2026 NamaBrand">
                    </div>
                </div>

                <!-- SECTION 2: USEFUL LINKS (4 TAUTAN) -->
                <div class="space-y-6">
                    <div class="border-b border-slate-100 dark:border-slate-700 pb-4">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">🔗 Useful Links (Tautan Berguna)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Atur label nama dan tujuan URL untuk 4 link di kolom Useful Link.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Link 1 -->
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 space-y-3 bg-slate-50/50 dark:bg-slate-900/50">
                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase">Link 1</span>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nama Tautan</label>
                                <input type="text" name="footer_link1_text" value="{{ \App\Models\Setting::get('footer_link1_text', 'Home') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">URL / Anchor</label>
                                <input type="text" name="footer_link1_url" value="{{ \App\Models\Setting::get('footer_link1_url', '#') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            </div>
                        </div>

                        <!-- Link 2 -->
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 space-y-3 bg-slate-50/50 dark:bg-slate-900/50">
                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase">Link 2</span>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nama Tautan</label>
                                <input type="text" name="footer_link2_text" value="{{ \App\Models\Setting::get('footer_link2_text', 'Features') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">URL / Anchor</label>
                                <input type="text" name="footer_link2_url" value="{{ \App\Models\Setting::get('footer_link2_url', '#services') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            </div>
                        </div>

                        <!-- Link 3 -->
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 space-y-3 bg-slate-50/50 dark:bg-slate-900/50">
                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase">Link 3</span>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nama Tautan</label>
                                <input type="text" name="footer_link3_text" value="{{ \App\Models\Setting::get('footer_link3_text', 'Pricing') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">URL / Anchor</label>
                                <input type="text" name="footer_link3_url" value="{{ \App\Models\Setting::get('footer_link3_url', '#projects') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            </div>
                        </div>

                        <!-- Link 4 -->
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 space-y-3 bg-slate-50/50 dark:bg-slate-900/50">
                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase">Link 4</span>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nama Tautan</label>
                                <input type="text" name="footer_link4_text" value="{{ \App\Models\Setting::get('footer_link4_text', 'Contact') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">URL / Anchor</label>
                                <input type="text" name="footer_link4_url" value="{{ \App\Models\Setting::get('footer_link4_url', '#chat-widget') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: MEDIA SOSIAL -->
                <div class="space-y-6">
                    <div class="border-b border-slate-100 dark:border-slate-700 pb-4">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">🌐 Media Sosial</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Atur URL akun jejaring sosial milikmu.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Facebook URL</label>
                            <input type="text" name="footer_facebook" value="{{ \App\Models\Setting::get('footer_facebook', '#') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Instagram URL</label>
                            <input type="text" name="footer_instagram" value="{{ \App\Models\Setting::get('footer_instagram', '#') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">X (Twitter) URL</label>
                            <input type="text" name="footer_twitter" value="{{ \App\Models\Setting::get('footer_twitter', '#') }}" class="block w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-500/30 transition cursor-pointer">
                        Simpan Pengaturan Footer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
