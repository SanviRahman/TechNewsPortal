<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredPosts = Post::with(['author', 'category', 'tags'])
            ->published()
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(5)
            ->get();

        $latestPosts = Post::with(['author', 'category', 'tags'])
            ->published()
            ->latest('published_at')
            ->take(10)
            ->get();

        $popularPosts = Post::with(['author', 'category'])
            ->published()
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->orderBy('name')
            ->get();

        $tags = Tag::withCount('posts')
            ->orderBy('name')
            ->get();

        return view('front.home', compact(
            'featuredPosts',
            'latestPosts',
            'popularPosts',
            'categories',
            'tags'
        ));
    }
}