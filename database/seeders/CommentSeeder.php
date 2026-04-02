<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $reader = User::role('Reader')->first() ?? User::first();
        $editor = User::role('Editor')->first() ?? User::first();
        $publishedPosts = Post::where('status', 'published')->get();

        if (!$reader || $publishedPosts->isEmpty()) {
            return;
        }

        foreach ($publishedPosts as $post) {
            $comment = Comment::create([
                'post_id' => $post->id,
                'user_id' => $reader->id,
                'parent_id' => null,
                'content' => 'This is a very informative article. Thanks for sharing.',
                'status' => 'approved',
                'approved_by' => $editor?->id,
                'approved_at' => now(),
            ]);

            Comment::create([
                'post_id' => $post->id,
                'user_id' => $reader->id,
                'parent_id' => $comment->id,
                'content' => 'I especially liked the explanation about Laravel architecture.',
                'status' => 'approved',
                'approved_by' => $editor?->id,
                'approved_at' => now(),
            ]);
        }
    }
}