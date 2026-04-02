<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StorePostRequest;
use App\Http\Requests\Author\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

    public function index(): View
    {
        $posts = auth()->user()
            ->posts()
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(10);

        return view('author.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->get();
        $tags = Tag::all();

        return view('author.posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = $this->postService->createPost($request->validated(), auth()->user());

        return redirect()
            ->route('author.posts.edit', $post)
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        abort_unless($post->user_id === auth()->id(), 403);

        $categories = Category::where('is_active', true)->get();
        $tags = Tag::all();

        return view('author.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->postService->updateDraft($post, $request->validated(), auth()->user());

        return back()->with('success', 'Post updated successfully.');
    }

    public function submit(Post $post): RedirectResponse
    {
        $this->postService->submitForReview($post, auth()->user());

        return back()->with('success', 'Post submitted for review.');
    }
}