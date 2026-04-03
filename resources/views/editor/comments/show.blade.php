<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Comment Details</h2>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card">
            <div class="card-body">
                <p><strong>Post:</strong> {{ $comment->post->title ?? '-' }}</p>
                <p><strong>User:</strong> {{ $comment->user->name ?? '-' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($comment->status) }}</p>
                <p><strong>Comment:</strong></p>
                <div class="border rounded p-3 bg-light">
                    {{ $comment->content }}
                </div>

                <div class="mt-4 d-flex gap-2">
                    @if ($comment->status === 'pending')
                        <form action="{{ route('editor.comments.approve', $comment) }}" method="POST">
                            @csrf
                            <button class="btn btn-success">Approve</button>
                        </form>

                        <form action="{{ route('editor.comments.reject', $comment) }}" method="POST">
                            @csrf
                            <button class="btn btn-warning">Reject</button>
                        </form>
                    @endif

                    <form action="{{ route('editor.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>