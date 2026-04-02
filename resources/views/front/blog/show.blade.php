<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 section-title">{{ $post->title }}</h2>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card page-card mb-4">
                    @if ($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" style="max-height: 420px; object-fit: cover;" alt="{{ $post->title }}">
                    @endif

                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-light text-dark">{{ $post->category->name ?? 'Uncategorized' }}</span>
                            <span class="small text-muted">{{ optional($post->published_at)->format('d M Y') }}</span>
                            <span class="small text-muted">{{ $post->views_count }} views</span>
                        </div>

                        <h1 class="h2 fw-bold mb-3">{{ $post->title }}</h1>
                        <p class="text-muted">By {{ $post->author->name ?? 'Unknown' }}</p>

                        <div class="post-body mt-4">
                            {!! nl2br(e($post->body)) !!}
                        </div>

                        <div class="mt-4">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="btn btn-outline-secondary btn-sm mb-2">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>

                        @auth
                            <div class="mt-4">
                                <form method="POST" action="{{ route('posts.like', $post) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Like Post</button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>

                <div class="card page-card">
                    <div class="card-body p-4">
                        <h3 class="h4 mb-4">Comments</h3>

                        @auth
                            <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-4">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Write a comment</label>
                                    <textarea name="content" rows="4" class="form-control" placeholder="Share your thoughts...">{{ old('content') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit Comment</button>
                            </form>
                        @else
                            <div class="alert alert-info">
                                <a href="{{ route('login') }}">Login</a> to comment on this post.
                            </div>
                        @endauth

                        @forelse ($post->approvedComments as $comment)
                            @if (is_null($comment->parent_id))
                                <div class="border rounded p-3 mb-3">
                                    <div class="fw-semibold">{{ $comment->user->name ?? 'User' }}</div>
                                    <div class="small text-muted mb-2">{{ $comment->created_at->diffForHumans() }}</div>
                                    <p class="mb-0">{{ $comment->content }}</p>

                                    @if ($comment->replies->count())
                                        <div class="ms-4 mt-3 border-start ps-3">
                                            @foreach ($comment->replies as $reply)
                                                <div class="mb-3">
                                                    <div class="fw-semibold">{{ $reply->user->name ?? 'User' }}</div>
                                                    <div class="small text-muted mb-1">{{ $reply->created_at->diffForHumans() }}</div>
                                                    <p class="mb-0">{{ $reply->content }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @empty
                            <p class="text-muted mb-0">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card sidebar-card">
                    <div class="card-body">
                        <h4 class="h5 mb-3">Related Posts</h4>
                        @forelse ($relatedPosts as $related)
                            <div class="mb-3">
                                <a href="{{ route('blog.show', $related->slug) }}" class="fw-semibold text-decoration-none text-dark">
                                    {{ $related->title }}
                                </a>
                                <div class="small text-muted">{{ optional($related->published_at)->format('d M Y') }}</div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No related posts found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>