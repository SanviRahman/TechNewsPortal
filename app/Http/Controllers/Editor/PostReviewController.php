<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostReviewController extends Controller
{
    public function __construct(private PostService $postService) {}

    public function index(): View
    {
        $posts = Post::with(['author', 'category'])
            ->pendingReview()
            ->latest()
            ->paginate(15);

        return view('editor.posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        $post->load(['author', 'category', 'tags']);

        return view('editor.posts.show', compact('post'));
    }

    public function approve(Request $request, Post $post): RedirectResponse
    {
        $this->postService->approve($post, auth()->user(), $request->input('review_notes'));

        return back()->with('success', 'Post approved successfully.');
    }

    public function reject(Request $request, Post $post): RedirectResponse
    {
        $this->postService->reject($post, auth()->user(), $request->input('review_notes'));

        return back()->with('success', 'Post rejected successfully.');
    }

    public function publish(Post $post): RedirectResponse
    {
        $this->postService->publish($post, auth()->user());

        return back()->with('success', 'Post published successfully.');
    }
}