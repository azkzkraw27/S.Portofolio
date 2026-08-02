<x-app-layout>
    <x-slot name="header">
        Tambah Artikel Baru
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <!-- Menampilkan Pesan Error Validasi jika ada data yang gagal -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-2xl shadow-sm">
                <p class="font-bold text-sm mb-1">Terjadi kesalahan pengisian:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 md:p-8">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul Artikel</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Kategori</label>
                    <input type="text" name="category" value="{{ old('category') }}" placeholder="Misal: Teknologi & Web, Desain Grafis" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Thumbnail / Gambar Sampul</label>
                    <input type="file" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-primary hover:file:bg-blue-100 border border-slate-300 dark:border-slate-700 rounded-xl cursor-pointer" accept="image/*">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Isi Konten Artikel</label>
                    <textarea name="content" rows="8" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary" required>{{ old('content') }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-brand-primary focus:ring-brand-primary cursor-pointer">
                    <label for="is_published" class="text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">Publikasikan artikel ini sekarang</label>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('posts.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 transition">Batal</a>
                    <button type="submit" class="bg-brand-primary hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-blue-500/30 transition cursor-pointer">Simpan Artikel</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
