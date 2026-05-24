<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Category;

class PortalLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $navCategories = Category::withCount(['articles' => function ($query) {
            $query->whereNotNull('published_at')->where('published_at', '<=', now());
        }])->orderByDesc('articles_count')->get();

        return view('layouts.portal', compact('navCategories'));
    }
}
