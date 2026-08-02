<x-app-layout>
    <x-slot name="header">
        Kelola FAQs (Frequently Asked Questions)
    </x-slot>

    <div class="space-y-6">
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="p-4 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 rounded-xl font-bold text-xs border border-emerald-200 dark:border-emerald-800">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah FAQ Baru -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm h-fit">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Tambah Pertanyaan Baru</h3>

                <form action="{{ route('faqs.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-2">Pertanyaan (Question)</label>
                        <input type="text" name="question" required placeholder="Contoh: Berapa lama pengerjaan sebuah project?" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                        @error('question')
                            <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-2">Jawaban (Answer)</label>
                        <textarea name="answer" rows="4" required placeholder="Tuliskan jawaban lengkap di sini..." class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition"></textarea>
                        @error('answer')
                            <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-lg shadow-blue-500/20 transition cursor-pointer">
                        + Tambah FAQ
                    </button>
                </form>
            </div>

            <!-- Daftar FAQ -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Daftar FAQs Dipublikasikan ({{ $faqs->count() }})</h3>

                @if($faqs->isEmpty())
                    <div class="text-center py-12 text-slate-400 dark:text-slate-500 text-sm">
                        Belum ada data FAQ yang ditambahkan.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($faqs as $faq)
                            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/40 flex justify-between items-start gap-4">
                                <div class="space-y-1">
                                    <h4 class="font-bold text-sm text-slate-800 dark:text-white">Q: {{ $faq->question }}</h4>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">A: {{ $faq->answer }}</p>
                                </div>

                                <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition" title="Hapus FAQ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
