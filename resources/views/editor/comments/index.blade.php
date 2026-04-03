<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Comment Moderation</h2>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" @selected($status === 'pending')>Pending</option>
                            <option value="approved" @selected($status === 'approved')>Approved</option>
                            <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                            <option value="spam" @selected($status === 'spam')>Spam</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card page-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Post</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comments as $comment)
                                <tr>
                                    <td>{{ $comment->post->title ?? '-' }}</td>
                                    <td>{{ $comment->user->name ?? '-' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($comment->content, 60) }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($comment->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $comment->created_at->format('d M Y h:i A') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('editor.comments.show', $comment) }}" class="btn btn-info btn-sm">View</a>

                                        @if ($comment->status === 'pending')
                                            <form action="{{ route('editor.comments.approve', $comment) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-success btn-sm">Approve</button>
                                            </form>

                                            <form action="{{ route('editor.comments.reject', $comment) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-warning btn-sm">Reject</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('editor.comments.destroy', $comment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this comment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No comments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $comments->links() }}
        </div>
    </div>
</x-app-layout>