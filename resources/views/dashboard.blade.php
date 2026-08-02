<x-app-layout>
    <x-slot name="header">
        Overview
    </x-slot>

    <div class="space-y-8 pb-12">

        <!-- 4 STAT CARDS ATAS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1: Pengunjung Hari Ini -->
            <div class="bg-gradient-to-r from-pink-500 to-rose-600 dark:from-pink-600 dark:to-rose-700 rounded-2xl p-6 shadow-md flex items-center justify-between text-white relative overflow-hidden">
                <div class="space-y-1 relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-pink-100">Pengunjung Hari Ini</p>
                    <h3 class="text-4xl font-black tracking-tight">{{ number_format($visitorsToday ?? 0) }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-white relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </div>
            </div>

            <!-- Card 2: Users -->
            <div class="bg-gradient-to-r from-blue-500 to-sky-600 dark:from-blue-600 dark:to-sky-700 rounded-2xl p-6 shadow-md flex items-center justify-between text-white relative overflow-hidden">
                <div class="space-y-1 relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-blue-100">Users</p>
                    <h3 class="text-4xl font-black tracking-tight">{{ number_format($totalUsers ?? 0) }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-white relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
            </div>

            <!-- Card 3: Total Artikel / Posts -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 dark:from-emerald-600 dark:to-teal-700 rounded-2xl p-6 shadow-md flex items-center justify-between text-white relative overflow-hidden">
                <div class="space-y-1 relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-100">Blog Posts</p>
                    <h3 class="text-4xl font-black tracking-tight">{{ number_format($totalPosts ?? 0) }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-white relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                </div>
            </div>

            <!-- Card 4: Total Projects -->
            <div class="bg-gradient-to-r from-amber-500 to-yellow-600 dark:from-amber-600 dark:to-yellow-700 rounded-2xl p-6 shadow-md flex items-center justify-between text-white relative overflow-hidden">
                <div class="space-y-1 relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-100">Projects</p>
                    <h3 class="text-4xl font-black tracking-tight">{{ number_format($totalProjects ?? 0) }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-white relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" /></svg>
                </div>
            </div>

        </div>

        <!-- LAYOUT DUA KOLOM -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- RECENT POSTS TABLE -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm overflow-hidden p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-wide">Recent Posts</h3>
                    <a href="{{ route('posts.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                        <thead class="text-slate-400 dark:text-slate-400 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100 dark:border-slate-700/60 bg-slate-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="py-3 px-3 w-10">#</th>
                                <th class="py-3 px-3">NAME</th>
                                <th class="py-3 px-3 text-right">CREATED AT</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/40">
                            @forelse($recentPosts as $index => $post)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                                    <td class="py-3.5 px-3 font-bold text-slate-400 dark:text-slate-500">{{ $index + 1 }}</td>
                                    <td class="py-3.5 px-3 font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="line-clamp-1">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td class="py-3.5 px-3 text-right text-slate-500 dark:text-slate-400 whitespace-nowrap font-mono text-[11px]">
                                        {{ $post->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-slate-400 dark:text-slate-500">Belum ada artikel yang dipublikasikan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ACTIVITIES LOGS -->
            <div class="lg:col-span-5 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm overflow-hidden p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-wide">Activities Logs</h3>
                    <a href="{{ route('chats.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">Lihat Chat</a>
                </div>

                <div class="space-y-4 max-h-[420px] overflow-y-auto pr-1">
                    @forelse($activities as $act)
                        <div class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                            <div class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/40 border border-blue-200 dark:border-blue-700 flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold text-xs shrink-0 mt-0.5">
                                {{ substr($act->sender_name ?? 'U', 0, 1) }}
                            </div>
                            <div class="text-xs space-y-1 leading-relaxed">
                                <p class="text-slate-800 dark:text-slate-200">
                                    <span class="font-bold text-blue-600 dark:text-blue-400">{{ $act->sender_name }}</span>
                                    <span class="text-slate-500 dark:text-slate-400">mengirim pesan:</span>
                                    <span class="text-slate-600 dark:text-slate-300 italic">"{{ Str::limit($act->message, 40) }}"</span>
                                </p>
                                <p class="text-[10px] text-slate-400 font-medium flex items-center gap-2">
                                    <span>{{ $act->created_at->diffForHumans() }}</span>
                                    <span>•</span>
                                    <span class="font-mono text-slate-500 dark:text-slate-400">({{ $act->sender_email }})</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 dark:text-slate-500 text-center py-6">Belum ada aktivitas pesan terbaru.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
