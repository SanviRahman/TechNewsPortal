<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 section-title">Create Post</h2>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card">
            <div class="card-body p-4">
                <form action="{{ route('author.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('author.posts._form')

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('author.posts.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>