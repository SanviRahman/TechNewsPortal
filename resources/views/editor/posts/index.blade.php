<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 section-title">Pending Reviews</h2>
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
                                <th>Author</th>
                                <th>Category</th>
                                <th>Submitted</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="fw-semibold">{{ $post->title }}</td>
                                    <td>{{ $post->author->name ?? '-' }}</td>
                                    <td>{{ $post->category->name ?? '-' }}</td>
                                    <td>{{ optional($post->submitted_at)->format('d M Y h:i A') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('editor.reviews.show', $post) }}" class="btn btn-primary btn-sm">Review</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No posts pending review.</td>
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