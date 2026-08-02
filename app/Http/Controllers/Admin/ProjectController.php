<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    // Fungsi untuk menampilkan halaman form tambah project
    public function create()
    {
        return view('admin.projects.create');
    }

    // Fungsi untuk memproses data dari form ke database
    public function store(Request $request)
    {
        // 1. Validasi data (Limit gambar dinaikkan menjadi 5MB)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        // 2. Proses upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        // 3. Simpan data ke database
        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_visible' => $request->has('is_visible'),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan!');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    // Fungsi untuk memproses perubahan data
    public function update(Request $request, Project $project)
    {
        // 1. Validasi data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        // 2. Siapkan path gambar (gunakan yang lama sebagai default)
        $imagePath = $project->image_path;

        // 3. Jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        // 4. Update data ke database
        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_visible' => $request->has('is_visible'),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui!');
    }

    // Fungsi untuk menghapus data
    public function destroy(Project $project)
    {
        // Hapus gambar dari folder storage jika ada
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }

        // Hapus data dari database
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus!');
    }
}
