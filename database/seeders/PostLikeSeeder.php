<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    public function run(): void
    {
        $reader = User::role('Reader')->first() ?? User::first();
        $publishedPosts = Post::where('status', 'published')->get();

        if (!$reader || $publishedPosts->isEmpty()) {
            return;
        }

        foreach ($publishedPosts as $post) {
            PostLike::firstOrCreate([
                'post_id' => $post->id,
                'user_id' => $reader->id,
            ], [
                'created_at' => now(),
            ]);
        }
    }
}