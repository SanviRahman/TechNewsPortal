<?php
namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Traits\UploadsFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PostService
{
    use UploadsFiles;

    public function createPost(array $data, User $author): Post
    {
        return DB::transaction(function () use ($data, $author) {
            if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
                $data['featured_image'] = $this->uploadFile($data['featured_image'], 'posts');
            }

            $tagIds = $data['tag_ids'] ?? [];
            unset($data['tag_ids']);

            $post = Post::create([
                 ...$data,
                'user_id' => $author->id,
                'status'  => 'draft',
            ]);

            if (! empty($tagIds)) {
                $post->tags()->sync($tagIds);
            }

            return $post->fresh(['author', 'category', 'tags']);
        });
    }

    public function updateDraft(Post $post, array $data, User $user): Post
    {
        if ($post->user_id !== $user->id && ! $user->can('posts.edit.any')) {
            throw ValidationException::withMessages([
                'authorization' => 'You are not allowed to edit this post.',
            ]);
        }

        if ($post->status === 'published' && ! $user->can('posts.edit.any')) {
            throw ValidationException::withMessages([
                'status' => 'You cannot edit a published post.',
            ]);
        }

        return DB::transaction(function () use ($post, $data) {
            if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
                $data['featured_image'] = $this->replaceFile(
                    $data['featured_image'],
                    $post->featured_image,
                    'posts'
                );
            }

            $tagIds = $data['tag_ids'] ?? null;
            unset($data['tag_ids']);

            $post->update($data);

            if (is_array($tagIds)) {
                $post->tags()->sync($tagIds);
            }

            return $post->fresh(['author', 'category', 'tags']);
        });
    }

    public function submitForReview(Post $post, User $user): Post
    {
        if ($post->user_id !== $user->id) {
            throw ValidationException::withMessages([
                'authorization' => 'You can submit only your own post.',
            ]);
        }

        if ($post->status !== 'draft') {
            throw ValidationException::withMessages([
                'status' => 'Only draft posts can be submitted for review.',
            ]);
        }

        $post->update([
            'status'       => 'pending_review',
            'submitted_at' => now(),
        ]);

        return $post->fresh();
    }

    public function approve(Post $post, User $editor, ?string $reviewNotes = null): Post
    {
        if (! $editor->can('posts.approve')) {
            throw ValidationException::withMessages([
                'authorization' => 'You are not allowed to approve posts.',
            ]);
        }

        if ($post->status !== 'pending_review') {
            throw ValidationException::withMessages([
                'status' => 'Only pending review posts can be approved.',
            ]);
        }

        $post->update([
            'status'       => 'approved',
            'approved_at'  => now(),
            'editor_id'    => $editor->id,
            'review_notes' => $reviewNotes,
        ]);

        return $post->fresh();
    }

    public function reject(Post $post, User $editor, ?string $reviewNotes = null): Post
    {
        if (! $editor->can('posts.review')) {
            throw ValidationException::withMessages([
                'authorization' => 'You are not allowed to review posts.',
            ]);
        }

        if ($post->status !== 'pending_review') {
            throw ValidationException::withMessages([
                'status' => 'Only pending review posts can be rejected.',
            ]);
        }

        $post->update([
            'status'       => 'rejected',
            'editor_id'    => $editor->id,
            'review_notes' => $reviewNotes,
        ]);

        return $post->fresh();
    }

    public function publish(Post $post, User $editor): Post
    {
        if (! $editor->can('posts.publish')) {
            throw ValidationException::withMessages([
                'authorization' => 'You are not allowed to publish posts.',
            ]);
        }

        if (! in_array($post->status, ['approved', 'published'])) {
            throw ValidationException::withMessages([
                'status' => 'Only approved posts can be published.',
            ]);
        }

        $post->update([
            'status'       => 'published',
            'published_at' => now(),
            'editor_id'    => $editor->id,
        ]);

        return $post->fresh();
    }
}
