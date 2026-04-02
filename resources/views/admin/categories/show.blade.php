<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">Category Details</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-md-3">Name</dt>
                    <dd class="col-md-9">{{ $category->name }}</dd>

                    <dt class="col-md-3">Slug</dt>
                    <dd class="col-md-9">{{ $category->slug }}</dd>

                    <dt class="col-md-3">Status</dt>
                    <dd class="col-md-9">{{ $category->is_active ? 'Active' : 'Inactive' }}</dd>

                    <dt class="col-md-3">Posts Count</dt>
                    <dd class="col-md-9">{{ $category->posts_count ?? 0 }}</dd>

                    <dt class="col-md-3">Description</dt>
                    <dd class="col-md-9">{{ $category->description ?: '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>