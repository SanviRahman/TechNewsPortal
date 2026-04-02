<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">Permission Details</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <h4>{{ $permission->name }}</h4>
            </div>
        </div>
    </div>
</x-app-layout>