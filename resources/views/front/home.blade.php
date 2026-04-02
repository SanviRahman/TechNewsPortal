<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 section-title">{{ setting('site_name', config('app.name')) }}</h2>
            <a href="{{ route('blog.index') }}" class="btn btn-primary btn-sm">Browse Blog</a>
        </div>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card page-card mb-4">
                    <div class="card-body p-4">
                        <h3 class="h4 mb-4">Featured Posts</h3>
                        <div class="row g-4">
                            @forelse ($featuredPosts as $post)
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        @if ($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $post->title }}">
                                        @endif
                                        <div class="card-body">
                                            <span class="badge badge-soft mb-2">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                            <h5 class="card-title">
                                                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                                                    {{ $post->title }}
                                                </a>
                                            </h5>
                                            <p class="card-text text-muted">{{ $post->excerpt }}</p>
                                        </div>
                                        <div class="card-footer bg-white border-0 d-flex justify-content-between">
                                            <small class="text-muted">{{ $post->author->name ?? 'Unknown' }}</small>
                                            <small class="text-muted">{{ optional($post->published_at)->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No featured posts found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="card page-card">
                    <div class="card-body p-4">
                        <h3 class="h4 mb-4">Latest Posts</h3>
                        @forelse ($latestPosts as $post)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <span class="badge bg-light text-dark">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                    <span class="text-muted small">{{ optional($post->published_at)->format('d M Y') }}</span>
                                    <span class="text-muted small">{{ $post->views_count }} views</span>
                                </div>
                                <h5>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <p class="text-muted mb-1">{{ $post->excerpt }}</p>
                                <small class="text-muted">By {{ $post->author->name ?? 'Unknown' }}</small>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No latest posts available.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card sidebar-card mb-4">
                    <div class="card-body">
                        <h4 class="h5 mb-3">Popular Posts</h4>
                        @forelse ($popularPosts as $post)
                            <div class="mb-3">
                                <a href="{{ route('blog.show', $post->slug) }}" class="fw-semibold text-decoration-none text-dark">
                                    {{ $post->title }}
                                </a>
                                <div class="small text-muted">{{ $post->views_count }} views</div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No popular posts found.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card sidebar-card mb-4">
                    <div class="card-body">
                        <h4 class="h5 mb-3">Categories</h4>
                        <ul class="list-group list-group-flush">
                            @forelse ($categories as $category)
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                                        {{ $category->name }}
                                    </a>
                                    <span class="badge bg-secondary">{{ $category->posts_count }}</span>
                                </li>
                            @empty
                                <li class="list-group-item px-0 text-muted">No categories available.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="card sidebar-card">
                    <div class="card-body">
                        <h4 class="h5 mb-3">Tags</h4>
                        <div class="d-flex flex-wrap gap-2">
                            @forelse ($tags as $tag)
                                <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="btn btn-outline-secondary btn-sm">
                                    #{{ $tag->name }}
                                </a>
                            @empty
                                <p class="text-muted mb-0">No tags available.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>