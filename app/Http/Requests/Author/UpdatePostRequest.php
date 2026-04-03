<?php

namespace App\Http\Requests\Author;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Post|null $post */
        $post = $this->route('post');

        if (!auth()->check() || !$post) {
            return false;
        }

        if (auth()->user()->hasRole('Super Admin') || auth()->user()->can('posts.edit.any')) {
            return true;
        }

        return auth()->user()->can('posts.edit.own')
            && $post->user_id === auth()->id()
            && $post->status !== 'published';
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
        ];
    }
}