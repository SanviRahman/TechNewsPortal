<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">Edit Tag</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.tags.update', $tag) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.tags._form')
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-light border">Back</a>
                        <button class="btn btn-primary">Update Tag</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>