<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerChatController extends Controller
{
    // Menampilkan daftar chat di Admin Panel
    public function index()
    {
        // Mengelompokkan chat berdasarkan email pengunjung unik
        $conversations = Chat::select('sender_name', 'sender_email', DB::raw('MAX(created_at) as latest_chat'))
            ->groupBy('sender_name', 'sender_email')
            ->orderBy('latest_chat', 'desc')
            ->get();

        return view('admin.chats.index', compact('conversations'));
    }

    // Menampilkan detail percakapan dengan pengunjung tertentu
    public function show($email)
    {
        $messages = Chat::where('sender_email', $email)->orderBy('created_at', 'asc')->get();

        // Tandai pesan dari user sebagai sudah dibaca
        Chat::where('sender_email', $email)->where('sender_type', 'user')->update(['is_read' => true]);

        $visitor = $messages->first();

        return view('admin.chats.show', compact('messages', 'visitor', 'email'));
    }

    // Admin membalas pesan
    public function reply(Request $request, $email)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $visitor = Chat::where('sender_email', $email)->first();

        Chat::create([
            'sender_name' => 'Admin (M. Azka Azikra)',
            'sender_email' => $email,
            'message' => $request->message,
            'sender_type' => 'admin',
            'is_read' => true,
        ]);

        return redirect()->route('chats.show', $email)->with('success', 'Balasan terkirim!');
    }

    // Publik mengirim pesan baru dari widget floating chat di Home
    public function storePublic(Request $request)
{
    $request->validate([
        'sender_name' => 'required|string|max:255',
        'sender_email' => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    Chat::create([
        'sender_name' => $request->sender_name,
        'sender_email' => $request->sender_email,
        'message' => $request->message,
        'sender_type' => 'user',
        'is_read' => false,
    ]);

    // Jika dikirim dari Fetch / AJAX (Widget Floating Chat di Home)
    if ($request->ajax() || $request->expectsJson()) {
        return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim!']);
    }

    // Jika dikirim dari Submit Form biasa (Halaman /user/chat)
    return back()->with('success', 'Pesan berhasil dikirim!');
}

    // Mengambil pesan secara real-time untuk AJAX polling (opsional/ringan)
    public function fetchMessages($email)
    {
        $messages = Chat::where('sender_email', $email)->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }
}
