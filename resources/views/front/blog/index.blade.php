<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 section-title">Blog Articles</h2>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('blog.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" value="{{ $search ?? request('search') }}" class="form-control" placeholder="Search posts...">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected(($categorySlug ?? request('category')) === $category->slug)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tag</label>
                        <select name="tag" class="form-select">
                            <option value="">All Tags</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->slug }}" @selected(($tagSlug ?? request('tag')) === $tag->slug)>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-100">Filter</button>
                        <a href="{{ route('blog.index') }}" class="btn btn-light border w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        @forelse ($posts as $post)
            <div class="card page-card mb-4">
                <div class="row g-0">
                    @if ($post->featured_image)
                        <div class="col-md-3">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid h-100 w-100 rounded-start" style="object-fit: cover;" alt="{{ $post->title }}">
                        </div>
                    @endif

                    <div class="{{ $post->featured_image ? 'col-md-9' : 'col-md-12' }}">
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-light text-dark">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                <span class="small text-muted">{{ optional($post->published_at)->format('d M Y') }}</span>
                                <span class="small text-muted">{{ $post->views_count }} views</span>
                            </div>

                            <h3 class="h4">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p class="text-muted">{{ $post->excerpt }}</p>

                            <div class="mb-3">
                                @foreach ($post->tags as $tag)
                                    <span class="badge rounded-pill text-bg-secondary">#{{ $tag->name }}</span>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">By {{ $post->author->name ?? 'Unknown' }}</small>
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card page-card">
                <div class="card-body text-center text-muted py-5">
                    No posts found.
                </div>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>