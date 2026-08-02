<x-app-layout>
    <x-slot name="header">
        Tambah Project Baru
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden p-6 md:p-8">

            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Input Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul Project</label>
                    <input type="text" name="title" id="title" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition" required placeholder="Contoh: Animasi Logo TVRI Jambi">
                </div>

                <!-- Input Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="4" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition" placeholder="Ceritakan detail project ini..."></textarea>
                </div>

                <!-- Input Upload Gambar -->
                <div>
                    <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Thumbnail / Gambar Project</label>
                    <input type="file" name="image" id="image" class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-primary hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-slate-300 border border-slate-300 dark:border-slate-700 rounded-xl transition" accept="image/*">
                    <p class="mt-2 text-xs text-slate-500">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                </div>

                <!-- Input Checkbox Visibilitas -->
                <div class="flex items-center gap-3 pt-2">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="is_visible" id="is_visible" value="1" checked class="w-5 h-5 rounded border-slate-300 text-brand-primary focus:ring-brand-primary dark:border-slate-600 dark:bg-slate-900">
                    </div>
                    <label for="is_visible" class="text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                        Tampilkan project ini di halaman depan portofolio
                    </label>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-100 dark:border-slate-700 mt-6">
                    <a href="{{ route('projects.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700 transition">Batal</a>

                    <button type="submit" class="bg-brand-primary hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-lg shadow-blue-500/30">
                        Simpan Project
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
