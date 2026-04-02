<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 section-title">Edit Post</h2>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card">
            <div class="card-body p-4">
                <form action="{{ route('author.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('author.posts._form')

                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div>
                            @if ($post->status === 'draft')
                                <form action="{{ route('author.posts.submit', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Submit For Review</button>
                                </form>
                            @else
                                <span class="text-muted">Current status: {{ ucfirst(str_replace('_', ' ', $post->status)) }}</span>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('author.posts.index') }}" class="btn btn-light border">Back</a>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>