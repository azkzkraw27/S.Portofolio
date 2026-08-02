<x-app-layout>
    <x-slot name="header">
        Percakapan dengan {{ $visitor->sender_name ?? $email }}
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex flex-col h-[600px]">

            <!-- Header Chat -->
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white" id="visitor-name">{{ $visitor->sender_name ?? 'Klien' }}</h3>
                    <p class="text-xs text-slate-500">{{ $email }}</p>
                </div>
                <a href="{{ route('chats.index') }}" class="text-sm text-brand-primary font-medium hover:underline">← Kembali ke Daftar Chat</a>
            </div>

            <!-- Ruang Pesan (Bubbles) yang diperbarui secara real-time -->
            <div id="admin-chat-container" class="flex-1 p-6 overflow-y-auto space-y-4 bg-slate-50/50 dark:bg-slate-900/30">
                @foreach ($messages as $msg)
                    <div class="flex flex-col {{ $msg->sender_type === 'admin' ? 'items-end' : 'items-start' }}">
                        <div class="max-w-md px-4 py-3 rounded-2xl text-sm {{ $msg->sender_type === 'admin' ? 'bg-brand-primary text-white rounded-br-none shadow-md' : 'bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 rounded-bl-none border border-slate-200 dark:border-slate-600 shadow-sm' }}">
                            {{ $msg->message }}
                        </div>
                        <span class="text-[10px] text-slate-400 mt-1 px-1">{{ $msg->created_at->format('d M Y, H:i') }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Form Balas Pesan (Tanpa Reload Halaman) -->
            <form id="admin-reply-form" onsubmit="sendAdminReply(event)" class="p-4 border-t border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800 flex gap-3">
                @csrf
                <input type="text" id="admin-msg-input" name="message" placeholder="Tulis balasan pesan untuk klien..." class="flex-1 px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-brand-primary focus:border-brand-primary" autocomplete="off" required>
                <button type="submit" class="bg-brand-primary hover:bg-blue-800 text-white px-6 py-3 rounded-xl font-medium text-sm transition shadow-lg shadow-blue-500/30 cursor-pointer">
                    Kirim Balasan
                </button>
            </form>

        </div>
    </div>
</x-app-layout>

<script>
    const targetEmail = "{{ $email }}";
    let adminPolling = null;

    // Scroll otomatis ke bawah saat pertama kali dibuka
    const container = document.getElementById('admin-chat-container');
    container.scrollTop = container.scrollHeight;

    // Jalankan auto-refresh pesan setiap 2.5 detik di halaman admin
    document.addEventListener("DOMContentLoaded", function() {
        adminPolling = setInterval(() => {
            fetchAdminMessages();
        }, 2500);
    });

    // Hentikan interval jika admin meninggalkan halaman ini
    window.addEventListener('beforeunload', function() {
        clearInterval(adminPolling);
    });

    function fetchAdminMessages() {
        fetch(`/chat/messages/${targetEmail}`)
            .then(res => res.json())
            .then(messages => {
                let html = '';
                messages.forEach(msg => {
                    const timeFormatted = new Date(msg.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });

                    if(msg.sender_type === 'admin') {
                        html += `
                            <div class="flex flex-col items-end">
                                <div class="max-w-md px-4 py-3 rounded-2xl text-sm bg-brand-primary text-white rounded-br-none shadow-md">${msg.message}</div>
                                <span class="text-[10px] text-slate-400 mt-1 px-1">${timeFormatted}</span>
                            </div>
                        `;
                    } else {
                        html += `
                            <div class="flex flex-col items-start">
                                <div class="max-w-md px-4 py-3 rounded-2xl text-sm bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 rounded-bl-none border border-slate-200 dark:border-slate-600 shadow-sm">${msg.message}</div>
                                <span class="text-[10px] text-slate-400 mt-1 px-1">${timeFormatted}</span>
                            </div>
                        `;
                    }
                });

                // Perbarui tampilan hanya jika ada perubahan pesan baru
                if(container.innerHTML !== html) {
                    container.innerHTML = html;
                    container.scrollTop = container.scrollHeight;
                }
            });
    }

    function sendAdminReply(e) {
        e.preventDefault();
        const messageInput = document.getElementById('admin-msg-input');
        const message = messageInput.value;

        fetch(`/customer-chats/${targetEmail}/reply`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => {
            if(res.ok) {
                messageInput.value = ''; // Kosongkan input
                fetchAdminMessages(); // Langsung muat ulang daftar chat seketika
            }
        });
    }
</script>
