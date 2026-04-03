<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 section-title">My Posts</h2>
            <a href="{{ route('author.posts.create') }}" class="btn btn-primary">Create Post</a>
        </div>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                            <tr>
                                <td class="fw-semibold">{{ $post->title }}</td>
                                <td>{{ $post->category->name ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $post->status)) }}</span>
                                </td>
                                <td>{{ $post->created_at->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('author.posts.edit', $post) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    @if(auth()->user()->hasRole('Super Admin') || auth()->id() === $post->user_id)
                                    <form action="{{ route('author.posts.destroy', $post) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    @endif

                                    @if ($post->status === 'draft')
                                    <form action="{{ route('author.posts.submit', $post) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No posts found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">{{ $posts->links() }}</div>
    </div>
</x-app-layout>