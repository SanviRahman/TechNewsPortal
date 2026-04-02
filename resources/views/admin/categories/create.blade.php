<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">Create Category</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    @include('admin.categories._form')
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">Cancel</a>
                        <button class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>