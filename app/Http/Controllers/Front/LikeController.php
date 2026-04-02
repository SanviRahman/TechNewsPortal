<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function toggle(Post $post): RedirectResponse
    {
        abort_unless($post->status === 'published', 404);

        $existingLike = $post->likes()->where('user_id', auth()->id())->first();

        if ($existingLike) {
            $existingLike->delete();

            return back()->with('success', 'Post unliked successfully.');
        }

        $post->likes()->create([
            'user_id' => auth()->id(),
            'created_at' => now(),
        ]);

        return back()->with('success', 'Post liked successfully.');
    }
}