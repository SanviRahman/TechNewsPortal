<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        abort_unless($post->status === 'published', 404);

        if ($request->filled('parent_id')) {
            $parentComment = Comment::where('id', $request->parent_id)
                ->where('post_id', $post->id)
                ->firstOrFail();
        }

        $post->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Comment submitted successfully. Waiting for approval.');
    }
}