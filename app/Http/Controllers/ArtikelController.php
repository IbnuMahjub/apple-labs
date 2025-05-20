<?php

namespace App\Http\Controllers;

use App\Models\tm_category;
use App\Models\tr_post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $breadcrumbTitle = 'Data Artikel';
        $breadcrumbs = [
            ['title' => 'Data Artikel', 'url' => '/data-artikel'],
            ['title' => 'absensi', 'url' => '/data-absensi'],
            ['title' => 'Tambah Artikel', 'url' => '/create-artikel'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);
        return view('dashboard.artikel.index', [
            'title' => 'Artikel',
            'active' => 'artikel',
            'data' => tr_post::with('category')->get()
        ]);
    }

    public function create()
    {
        $breadcrumbTitle = 'Tambah Artikel';
        $breadcrumbs = [
            ['title' => 'Data Artikel', 'url' => '/data-artikel'],
            ['title' => 'absensi', 'url' => '/data-absensi'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);
        return view('dashboard.artikel.create', [
            'title' => 'Tambah Artikel',
            'active' => 'artikel',
            'categories' => tm_category::all()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'category_id' => 'required|exists:tm_categories,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('artikel');
        }
        tr_post::create($validated);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit($id)
    {
        $breadcrumbTitle = 'Data Artikel';
        $breadcrumbs = [
            ['title' => 'Data Artikel', 'url' => '/data-artikel'],
            ['title' => 'absensi', 'url' => '/data-absensi'],
            ['title' => 'Tambah Artikel', 'url' => '/create-artikel'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);
        $post = tr_post::find($id);
        $categories = tm_category::all();
        return view('dashboard.artikel.edit', [
            'title' => 'Edit Artikel',
            'active' => 'artikel',
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:tm_categories,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar bersifat opsional
        ]);

        $post = tr_post::find($id);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::delete($post->image);
            }

            $validated['image'] = $request->file('image')->store('artikel');
        }

        $post->update($validated);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }


    public function destroy($id)
    {
        $post = tr_post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan.'
            ], 404);
        }


        if ($post->image) {
            Storage::delete($post->image);
        }

        // Hapus artikel
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus.'
        ]);
    }
}
