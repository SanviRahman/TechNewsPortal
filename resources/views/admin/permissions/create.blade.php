<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">Create Permission</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.permissions.store') }}">
                    @csrf
                    @include('admin.permissions._form')
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-light border">Cancel</a>
                        <button class="btn btn-primary">Save Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>