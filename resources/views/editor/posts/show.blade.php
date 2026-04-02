<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 section-title">Review Post</h2>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card mb-4">
            <div class="card-body p-4">
                <div class="mb-3 text-muted">
                    Author: {{ $post->author->name ?? '-' }} |
                    Category: {{ $post->category->name ?? '-' }} |
                    Status: {{ ucfirst(str_replace('_', ' ', $post->status)) }}
                </div>

                <h1 class="h2 fw-bold mb-3">{{ $post->title }}</h1>

                @if ($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid rounded mb-4" alt="{{ $post->title }}">
                @endif

                <p class="text-muted">{{ $post->excerpt }}</p>

                <div class="post-body mt-4">
                    {!! nl2br(e($post->body)) !!}
                </div>

                <div class="mt-4">
                    @foreach ($post->tags as $tag)
                        <span class="badge text-bg-secondary">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card page-card">
            <div class="card-body p-4">
                <h3 class="h5 mb-4">Editorial Action</h3>

                <div class="row g-4">
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('editor.reviews.approve', $post) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Review Notes</label>
                                <textarea name="review_notes" rows="4" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Approve Post</button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <form method="POST" action="{{ route('editor.reviews.reject', $post) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Rejection Notes</label>
                                <textarea name="review_notes" rows="4" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Reject Post</button>
                        </form>
                    </div>
                </div>

                @if (in_array($post->status, ['approved', 'published']))
                    <div class="mt-4 pt-4 border-top">
                        <form method="POST" action="{{ route('editor.reviews.publish', $post) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Publish Post</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>