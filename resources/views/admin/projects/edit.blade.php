<x-app-layout>
    <x-slot name="header">
        Edit Project
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden p-6 md:p-8">

            <form id="edit-form" action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Tampilkan Pesan Error -->
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
                        <div class="text-sm text-red-700 dark:text-red-300">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Input Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul Project</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition" required>
                </div>

                <!-- Input Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="4" class="block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition">{{ old('description', $project->description) }}</textarea>
                </div>

                <!-- Preview Gambar Lama & Upload Gambar Baru -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Thumbnail / Gambar Project</label>

                    @if($project->image_path)
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $project->image_path) }}" alt="Preview" class="h-32 w-auto rounded-lg border border-slate-200 dark:border-slate-700 object-cover">
                        </div>
                    @endif

                    <input type="file" name="image" id="image" class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-primary hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-slate-300 border border-slate-300 dark:border-slate-700 rounded-xl transition" accept="image/*">
                    <p class="mt-2 text-xs text-slate-500">Biarkan kosong jika tidak ingin mengubah gambar. Maksimal 5MB.</p>
                </div>

                <!-- Input Checkbox Visibilitas -->
                <div class="flex items-center gap-3 pt-2">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="is_visible" id="is_visible" value="1" {{ $project->is_visible ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-brand-primary focus:ring-brand-primary dark:border-slate-600 dark:bg-slate-900">
                    </div>
                    <label for="is_visible" class="text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                        Tampilkan project ini di halaman depan portofolio
                    </label>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-100 dark:border-slate-700 mt-6">
                    <a href="{{ route('projects.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700 transition">Batal</a>

                    <button type="button" onclick="confirmEdit()" class="bg-brand-primary hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-lg shadow-blue-500/30">
                        Update Project
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>

<!-- Script ditaruh langsung di sini agar terpanggil dengan sempurna -->
<script>
    function confirmEdit() {
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Pastikan data yang Anda ubah sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1e3a8a',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Periksa Lagi'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                document.getElementById('edit-form').submit();
            }
        })
    }
</script>
