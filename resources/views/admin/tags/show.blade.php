<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">Tag Details</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-md-3">Name</dt>
                    <dd class="col-md-9">{{ $tag->name }}</dd>

                    <dt class="col-md-3">Slug</dt>
                    <dd class="col-md-9">{{ $tag->slug }}</dd>

                    <dt class="col-md-3">Posts Count</dt>
                    <dd class="col-md-9">{{ $tag->posts_count ?? 0 }}</dd>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>