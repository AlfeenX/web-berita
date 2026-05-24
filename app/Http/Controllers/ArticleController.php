<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['category', 'user']);

        // Filter pencarian berdasarkan judul atau isi konten
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $articles = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return redirect()->route('categories.index')->with('error', 'Silakan buat kategori terlebih dahulu sebelum menulis berita.');
        }
        $tags = Tag::all();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:10|max:255',
            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'nullable | exists:tags,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category_id.required' => 'Kategori artikel wajib dipilih.',
            'content.required' => 'Konten artikel wajib ditulis.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $article = Article::create([
            'user_id' => Auth::id(),
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')) . '-' . time(),
            'content' => $request->input('content'),
            'image' => $imagePath,
        ]);

        if ($request->has('tag_id')) {
            $article->tags()->sync($request->input('tag_id'));
        }

        return redirect()->route('articles.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'tag_id' => 'nullable | exists:tags,id'
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category_id.required' => 'Kategori artikel wajib dipilih.',
            'content.required' => 'Konten artikel wajib ditulis.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $imagePath = $article->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $article->update([
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')) . '-' . $article->id,
            'content' => $request->input('content'),
            'image' => $imagePath,
        ]);

        // Sync ke pivot table
        if (isset($validated['tag_id'])) {
            $article->tags()->sync($validated['tag_id']);
        } else {
            $article->tags()->sync([]);
        }

        return redirect()->route('articles.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        // Delete image if exists
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Berita berhasil dihapus!');
    }
}
