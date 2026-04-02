@php
    $selectedTags = old('tag_ids', isset($post) ? $post->tags->pluck('id')->toArray() : []);
@endphp

<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Title</label>
        <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Featured Image</label>
        <input type="file" name="featured_image" class="form-control">
        @if (!empty($post?->featured_image))
            <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-thumbnail mt-2" style="height: 120px;" alt="Featured Image">
        @endif
    </div>

    <div class="col-12">
        <label class="form-label">Excerpt</label>
        <textarea name="excerpt" rows="3" class="form-control">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label">Body</label>
        <textarea name="body" rows="10" class="form-control" required>{{ old('body', $post->body ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label">Tags</label>
        <div class="row g-2">
            @foreach ($tags as $tag)
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="form-check border rounded p-2">
                        <input class="form-check-input" type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}" @checked(in_array($tag->id, $selectedTags))>
                        <label class="form-check-label" for="tag{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Meta Title</label>
        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Meta Description</label>
        <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
    </div>
</div>