<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleDetailController extends Controller
{
    public function show(string $slug)
    {
        $article = Article::published()
            ->with(['category', 'user.profile', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Related articles from same category (exclude current)
        $related = Article::published()
            ->with(['category', 'user'])
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        // Count author's published articles
        $authorArticleCount = Article::published()
            ->where('user_id', $article->user_id)
            ->count();

        return view('articles.show', compact('article', 'related', 'authorArticleCount'));
    }
}
