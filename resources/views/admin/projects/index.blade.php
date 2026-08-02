<x-app-layout>
    <x-slot name="header">
        Kelola Data Project
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Portofolio Project</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Kelola semua daftar karya dan project Anda di sini.</p>
            </div>

            <a href="{{ route('projects.create') }}" class="bg-brand-primary hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl font-medium transition shadow-lg shadow-blue-500/30 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Project
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 text-sm">
                            <th class="px-6 py-4 font-medium w-16">No</th>
                            <th class="px-6 py-4 font-medium">Thumbnail</th>
                            <th class="px-6 py-4 font-medium">Judul Project</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($projects as $key => $project)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 text-slate-500">{{ $key + 1 }}</td>
                                <td class="px-6 py-4">
                                    @if($project->image_path)
                                        <img src="{{ asset('storage/' . $project->image_path) }}" alt="thumbnail" class="w-16 h-16 object-cover rounded-lg border border-slate-200 dark:border-slate-600">
                                    @else
                                        <div class="w-16 h-16 bg-slate-200 dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-400 text-xs">No Image</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-900 dark:text-slate-200 font-medium">
                                    {{ $project->title }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($project->is_visible)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs font-bold">Ditampilkan</span>
                                    @else
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 rounded-full text-xs font-bold">Disembunyikan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('projects.edit', $project->id) }}" class="text-brand-accent hover:text-blue-700 font-medium">Edit</a>

                                    <!-- Form Hapus dengan ID Unik -->
                                    <form id="delete-form-{{ $project->id }}" action="{{ route('projects.destroy', $project->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $project->id }})" class="text-red-500 hover:text-red-700 font-medium ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada data project. Silakan tambah project baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Script SweetAlert2 untuk Konfirmasi Hapus Modern -->
<script>
    function confirmDelete(projectId) {
        Swal.fire({
            title: 'Hapus Project Ini?',
            text: "Data beserta file gambar akan dihapus permanen dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Warna merah (Tailwind red-500)
            cancelButtonColor: '#64748b',  // Warna abu-abu (Tailwind slate-500)
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading animasi saat proses hapus berjalan
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                // Submit form hapus sesuai ID project yang dipilih
                document.getElementById('delete-form-' + projectId).submit();
            }
        })
    }
</script>
