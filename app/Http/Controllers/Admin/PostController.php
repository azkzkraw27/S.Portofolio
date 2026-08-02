<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Menampilkan daftar artikel di Admin
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    // Menampilkan form tambah artikel
    public function create()
    {
        return view('admin.posts.create');
    }

    // Menyimpan artikel baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'content' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title' => $request->title,
            'category' => $request->category,
            'image_path' => $imagePath,
            'content' => $request->content,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // Menampilkan form edit artikel
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    // Mengupdate artikel
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'content' => 'required|string',
        ]);

        $imagePath = $post->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Jika judul berubah, perbarui slug-nya
        if ($request->title !== $post->title) {
            $post->title = $request->title;
        }

        $post->update([
            'category' => $request->category,
            'image_path' => $imagePath,
            'content' => $request->content,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    // Menghapus artikel
    public function destroy(Post $post)
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Artikel berhasil dihapus.');
    }

    // Menampilkan detail artikel untuk pengunjung publik
    public function showPublic($slug)
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('posts.show', compact('post'));
    }
}
