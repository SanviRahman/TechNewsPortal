<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author', 'category', 'tags'])
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('front.blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        abort_unless($post->status === 'published', 404);

        $post->load([
            'author',
            'category',
            'tags',
            'approvedComments.user',
        ]);

        $post->increment('views_count');

        return view('front.blog.show', compact('post'));
    }
}
