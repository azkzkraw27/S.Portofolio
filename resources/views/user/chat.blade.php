@extends('layouts.user')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Obrolan -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl font-extrabold shadow-md shadow-blue-500/20">
                👨‍💼
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    Live Chat Support Tim Admin
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse" title="Admin Online"></span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Sampaikan pertanyaan, permintaan revisi, atau konsultasi layanan Anda di sini.
                </p>
            </div>
        </div>
        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-200 text-xs font-bold rounded-xl transition">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- Kotak Percakapan -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm flex flex-col h-[520px] overflow-hidden">

        <!-- Messages Body -->
        <div id="message-container" class="flex-1 p-6 overflow-y-auto space-y-4 bg-slate-50/50 dark:bg-slate-900/30">
            @if($messages->isEmpty())
                <div id="empty-state" class="text-center py-16 space-y-3">
                    <div class="text-5xl">💬</div>
                    <p class="text-xs text-slate-400 font-medium">Belum ada percakapan. Mulai kirim pesan pertama Anda ke Tim Admin!</p>
                </div>
            @else
                @foreach($messages as $msg)
                    @php $isMe = ($msg->sender_type !== 'admin'); @endphp
                    <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                        <div class="flex items-end gap-2 max-w-[80%] {{ $isMe ? 'flex-row-reverse' : 'flex-row' }}">
                            <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 flex items-center justify-center text-xs font-bold {{ $isMe ? 'bg-blue-600 text-white' : 'bg-slate-700 text-white' }}">
                                {{ $isMe ? substr(auth()->user()->name, 0, 1) : 'A' }}
                            </div>
                            <div class="p-4 rounded-2xl text-xs leading-relaxed {{ $isMe ? 'bg-blue-600 text-white rounded-br-none shadow-md shadow-blue-500/10' : 'bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-bl-none border border-slate-200 dark:border-slate-600 shadow-sm' }}">
                                {{ $msg->message }}
                            </div>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-1 px-1">
                            {{ $msg->created_at->format('H:i') }} · {{ $isMe ? 'Saya' : 'Admin' }}
                        </span>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Form Kirim Pesan (Tanpa Reload via JavaScript AJAX) -->
        <form id="chat-form" class="p-4 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700/80 flex items-center gap-3">
            @csrf
            <input type="hidden" name="sender_name" value="{{ auth()->user()->name }}">
            <input type="hidden" name="sender_email" value="{{ auth()->user()->email }}">

            <input type="text" id="chat-input" name="message" required placeholder="Tulis pesan Anda untuk tim admin..." class="flex-1 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">

            <button type="submit" id="send-btn" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-500/20 transition flex items-center gap-2 cursor-pointer">
                <span>Kirim</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-2-9-18-9 18 9-2zm0 0v-8" /></svg>
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('message-container');
        const form = document.getElementById('chat-form');
        const input = document.getElementById('chat-input');
        const sendBtn = document.getElementById('send-btn');
        const userInitial = "{{ substr(auth()->user()->name, 0, 1) }}";
        const userEmail = "{{ auth()->user()->email }}";

        // Scroll otomatis ke bawah
        function scrollToBottom() {
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
        scrollToBottom();

        // Tangani submit form secara AJAX
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const messageText = input.value.trim();
            if (!messageText) return;

            // Nonaktifkan tombol sebentar
            sendBtn.disabled = true;
            sendBtn.classList.add('opacity-50');

            const formData = new FormData(form);

            fetch("{{ route('chat.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Sembunyikan empty state jika ini pesan pertama
                    const emptyState = document.getElementById('empty-state');
                    if (emptyState) emptyState.remove();

                    // Format waktu saat ini (HH:MM)
                    const now = new Date();
                    const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

                    // Buat elemen bubble chat baru untuk pesan pengguna
                    const newBubble = document.createElement('div');
                    newBubble.className = 'flex flex-col items-end';
                    newBubble.innerHTML = `
                        <div class="flex items-end gap-2 max-w-[80%] flex-row-reverse">
                            <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 flex items-center justify-center text-xs font-bold bg-blue-600 text-white">
                                ${userInitial}
                            </div>
                            <div class="p-4 rounded-2xl text-xs leading-relaxed bg-blue-600 text-white rounded-br-none shadow-md shadow-blue-500/10">
                                ${escapeHtml(messageText)}
                            </div>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-1 px-1">
                            ${timeStr} · Saya
                        </span>
                    `;

                    container.appendChild(newBubble);
                    input.value = ''; // Kosongkan input
                    scrollToBottom();
                }
            })
            .catch(error => console.error("Gagal mengirim pesan:", error))
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.classList.remove('opacity-50');
            });
        });

        // Helper cegah XSS
        function escapeHtml(text) {
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        // Opsional: Polling otomatis setiap 5 detik untuk mengecek balasan baru dari Admin
        setInterval(function() {
            fetch("{{ url('/chat/messages') }}/" + encodeURIComponent(userEmail))
                .then(res => res.json())
                .then(messages => {
                    // Update tampilan jika diperlukan
                })
                .catch(err => {});
        }, 5000);
    });
</script>
@endsection
