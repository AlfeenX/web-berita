<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with dynamic data.
     */
    public function index()
    {
        // 1. Core aggregates
        $totalArticles = Article::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();

        // 2. Growth / trends (last 7 days)
        $articlesThisWeek = Article::where('created_at', '>=', now()->subDays(7))->count();
        $usersThisWeek = User::where('created_at', '>=', now()->subDays(7))->count();

        // 3. Eager load recent activity
        $recentArticles = Article::with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        // 4. Popular categories (Breakdown)
        $categoryBreakdown = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalArticles',
            'totalCategories',
            'totalUsers',
            'articlesThisWeek',
            'usersThisWeek',
            'recentArticles',
            'recentUsers',
            'categoryBreakdown'
        ));
    }
}
