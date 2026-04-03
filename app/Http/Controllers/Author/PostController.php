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
        $user = auth()->user();

        $posts = Post::with(['author', 'category', 'tags'])
            ->when(!$user->hasRole('Super Admin'), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
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
        $user = auth()->user();

        abort_unless(
            $user->hasRole('Super Admin') || $post->user_id === $user->id,
            403
        );

        $categories = Category::where('is_active', true)->get();
        $tags = Tag::all();

        return view('author.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $user = auth()->user();

        abort_unless(
            $user->hasRole('Super Admin') || $post->user_id === $user->id,
            403
        );

        $this->postService->updateDraft($post, $request->validated(), $user);

        return back()->with('success', 'Post updated successfully.');
    }

    public function submit(Post $post): RedirectResponse
    {
        $user = auth()->user();

        abort_unless(
            $user->hasRole('Super Admin') || $post->user_id === $user->id,
            403
        );

        $this->postService->submitForReview($post, $user);

        return back()->with('success', 'Post submitted for review.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $user = auth()->user();

        if ($user->hasRole('Super Admin') || $user->can('posts.delete.any')) {
            $post->delete();

            return redirect()
                ->route('author.posts.index')
                ->with('success', 'Post deleted successfully.');
        }

        if ($user->can('posts.delete.own') && $post->user_id === $user->id) {
            $post->delete();

            return redirect()
                ->route('author.posts.index')
                ->with('success', 'Post deleted successfully.');
        }

        abort(403, 'You are not allowed to delete this post.');
    }
}