<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        if ($user->can('posts.edit.any')) {
            return true;
        }

        return $user->can('posts.edit.own')
            && $post->user_id === $user->id
            && in_array($post->status, ['draft', 'rejected']);
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->can('posts.delete.any')) {
            return true;
        }

        return $user->can('posts.delete.own') && $post->user_id === $user->id;
    }
}