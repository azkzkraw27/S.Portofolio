<x-app-layout>
    <x-slot name="header">
        Edit Artikel
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 md:p-8">
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul Artikel</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $post->category) }}" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Thumbnail Saat Ini</label>
                    @if($post->image_path)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Thumb" class="h-32 w-auto object-cover rounded-xl border">
                        </div>
                    @endif
                    <input type="file" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-primary hover:file:bg-blue-100 border border-slate-300 dark:border-slate-700 rounded-xl" accept="image/*">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Isi Konten Artikel</label>
                    <textarea name="content" rows="8" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary" required>{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ $post->is_published ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-brand-primary focus:ring-brand-primary">
                    <label for="is_published" class="text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">Publikasikan artikel ini</label>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('posts.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600">Batal</a>
                    <button type="submit" class="bg-brand-primary hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-blue-500/30 cursor-pointer">Update Artikel</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
