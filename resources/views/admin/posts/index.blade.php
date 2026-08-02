<x-app-layout>
    <x-slot name="header">
        Kelola Blog & Artikel
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Artikel</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Tulis dan kelola wawasan atau artikel portofolio Anda.</p>
            </div>
            <a href="{{ route('posts.create') }}" class="bg-brand-primary hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl font-medium transition shadow-lg shadow-blue-500/30 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Artikel
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 text-sm">
                            <th class="px-6 py-4 font-medium w-16">No</th>
                            <th class="px-6 py-4 font-medium">Thumbnail</th>
                            <th class="px-6 py-4 font-medium">Judul Artikel</th>
                            <th class="px-6 py-4 font-medium">Kategori</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($posts as $key => $post)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 text-slate-500">{{ $key + 1 }}</td>
                                <td class="px-6 py-4">
                                    @if($post->image_path)
                                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="thumb" class="w-16 h-12 object-cover rounded-lg border border-slate-200 dark:border-slate-600">
                                    @else
                                        <div class="w-16 h-12 bg-slate-200 dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-400 text-[10px]">No Image</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-900 dark:text-slate-200 font-bold max-w-xs truncate">
                                    {{ $post->title }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    <span class="px-2.5 py-1 bg-blue-50 text-brand-primary dark:bg-blue-900/30 dark:text-brand-accent rounded-md text-xs font-semibold">{{ $post->category }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($post->is_published)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs font-bold">Published</span>
                                    @else
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 rounded-full text-xs font-bold">Draft</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="text-brand-accent hover:text-blue-700 font-medium">Edit</a>
                                    <form id="delete-post-{{ $post->id }}" action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeletePost({{ $post->id }})" class="text-red-500 hover:text-red-700 font-medium ml-2 cursor-pointer">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada artikel. Silakan buat artikel baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function confirmDeletePost(id) {
        Swal.fire({
            title: 'Hapus Artikel?',
            text: "Artikel ini akan dihapus permanen dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-post-' + id).submit();
            }
        })
    }
</script>
