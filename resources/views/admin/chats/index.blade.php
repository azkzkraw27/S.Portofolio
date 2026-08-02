<x-app-layout>
    <x-slot name="header">
        Customer Chat
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Pesan Masuk Klien</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Kelola dan balas percakapan dari pengunjung website.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse ($conversations as $conv)
                    @php
                        $unreadCount = \App\Models\Chat::where('sender_email', $conv->sender_email)
                            ->where('sender_type', 'user')
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    <a href="{{ route('chats.show', $conv->sender_email) }}" class="flex items-center justify-between p-6 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/40 text-brand-primary dark:text-brand-accent rounded-full flex items-center justify-center font-bold text-lg">
                                {{ strtoupper(substr($conv->sender_name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                    {{ $conv->sender_name }}
                                    @if($unreadCount > 0)
                                        <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">{{ $unreadCount }} Pesan Baru</span>
                                    @endif
                                </h4>
                                <p class="text-sm text-slate-500">{{ $conv->sender_email }}</p>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ \Carbon\Carbon::parse($conv->latest_chat)->diffForHumans() }}
                        </div>
                    </a>
                @empty
                    <div class="p-12 text-center text-slate-500 dark:text-slate-400">
                        Belum ada pesan masuk dari klien.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
