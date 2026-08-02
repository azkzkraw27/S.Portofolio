<x-app-layout>
    <x-slot name="header">
        Kelola Testimoni Klien
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 rounded-xl font-bold text-xs border border-emerald-200 dark:border-emerald-800">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah Testimoni -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm h-fit">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Tambah Testimoni Baru</h3>

                <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-2">Nama Klien</label>
                        <input type="text" name="client_name" required placeholder="Contoh: Budi Santoso" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-2">Jabatan / Perusahaan</label>
                        <input type="text" name="client_title" required placeholder="Contoh: CEO at TechCorp" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-2">Rating Bintang</label>
                        <select name="rating" required class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                            <option value="5" selected>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                            <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                            <option value="3">⭐⭐⭐ (3 Bintang)</option>
                            <option value="2">⭐⭐ (2 Bintang)</option>
                            <option value="1">⭐ (1 Bintang)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-2">Foto Klien (Opsional)</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 border border-slate-200 dark:border-slate-700 rounded-xl dark:bg-slate-900/60">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-2">Ulasan / Testimoni</label>
                        <textarea name="quote" rows="4" required placeholder="Tuliskan testimoni dari klien di sini..." class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-lg shadow-blue-500/20 transition cursor-pointer">
                        + Tambah Testimoni
                    </button>
                </form>
            </div>

            <!-- Daftar Testimoni -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Daftar Testimoni Dipublikasikan ({{ $testimonials->count() }})</h3>

                @if($testimonials->isEmpty())
                    <div class="text-center py-12 text-slate-400 dark:text-slate-500 text-sm">
                        Belum ada data testimoni yang ditambahkan.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($testimonials as $item)
                            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/40 flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            @if($item->avatar)
                                                <img src="{{ asset('storage/' . $item->avatar) }}" alt="{{ $item->client_name }}" class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                                                    {{ substr($item->client_name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="font-bold text-xs text-slate-800 dark:text-white">{{ $item->client_name }}</h4>
                                                <p class="text-[10px] text-slate-400">{{ $item->client_title }}</p>
                                            </div>
                                        </div>
                                        <span class="text-amber-400 text-xs">
                                            {{ str_repeat('★', $item->rating) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 dark:text-slate-300 italic leading-relaxed">
                                        "{{ $item->quote }}"
                                    </p>
                                </div>

                                <div class="flex justify-end pt-2 border-t border-slate-200/60 dark:border-slate-700/60">
                                    <form action="{{ route('testimonials.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-red-500 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
