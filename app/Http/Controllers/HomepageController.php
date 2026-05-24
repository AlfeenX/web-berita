<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with(['category', 'user']);

        // Filter by search keyword
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Featured: 5 most recent published articles (only fetch if no filters are applied)
        $featured = collect();
        if (!$request->filled('search') && !$request->filled('category')) {
            $featured = Article::published()
                ->with(['category', 'user'])
                ->latest('published_at')
                ->take(5)
                ->get();
            
            // Exclude featured articles from the latest list
            $query->whereNotIn('id', $featured->pluck('id'));
        }

        // Latest articles (paginated)
        $latest = $query->latest('published_at')->paginate(12)->withQueryString();

        // Trending: random selection simulating "most read"
        $trending = Article::published()
            ->with(['category', 'user'])
            ->inRandomOrder()
            ->take(6)
            ->get();

        // All categories with article count
        $categories = Category::withCount(['articles' => function ($query) {
            $query->whereNotNull('published_at')
                  ->where('published_at', '<=', now());
        }])->get();

        return view('homepage', compact('featured', 'latest', 'trending', 'categories'));
    }
}
