<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $categorySlug = $request->string('category')->toString();
        $tagSlug = $request->string('tag')->toString();

        $posts = Post::with(['author', 'category', 'tags'])
            ->published()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->when($tagSlug, function ($query) use ($tagSlug) {
                $query->whereHas('tags', function ($q) use ($tagSlug) {
                    $q->where('slug', $tagSlug);
                });
            })
            ->latest('published_at')
            ->paginate(setting('posts_per_page', 10))
            ->withQueryString();

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('front.blog.index', compact('posts', 'categories', 'tags', 'search', 'categorySlug', 'tagSlug'));
    }

    public function show(string $slug): View
    {
        $post = Post::with([
                'author',
                'category',
                'tags',
                'approvedComments.user',
                'approvedComments.replies.user'
            ])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views_count');

        $relatedPosts = Post::with(['author', 'category'])
            ->published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('front.blog.show', compact('post', 'relatedPosts'));
    }
}