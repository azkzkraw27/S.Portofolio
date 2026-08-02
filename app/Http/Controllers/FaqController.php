<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Pertanyaan FAQ berhasil ditambahkan!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->back()->with('success', 'Pertanyaan FAQ berhasil dihapus!');
    }
}
