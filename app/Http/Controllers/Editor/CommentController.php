<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'pending');

        $comments = Comment::with(['post', 'user', 'parent'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('editor.comments.index', compact('comments', 'status'));
    }

    public function show(Comment $comment): View
    {
        $comment->load(['post', 'user', 'parent', 'replies.user']);

        return view('editor.comments.show', compact('comment'));
    }

    public function approve(Comment $comment): RedirectResponse
    {
        $comment->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Comment approved successfully.');
    }

    public function reject(Comment $comment): RedirectResponse
    {
        $comment->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Comment rejected successfully.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}