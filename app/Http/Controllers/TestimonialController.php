<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Tampilkan daftar Testimoni di Dashboard Admin.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Simpan testimoni baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_title' => 'required|string|max:255',
            'quote' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('testimonials', 'public');
        }

        Testimonial::create([
            'client_name' => $validated['client_name'],
            'client_title' => $validated['client_title'],
            'quote' => $validated['quote'],
            'avatar' => $avatarPath,
            'rating' => $validated['rating'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Testimoni klien berhasil ditambahkan!');
    }

    /**
     * Hapus testimoni.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimoni klien berhasil dihapus!');
    }
}
