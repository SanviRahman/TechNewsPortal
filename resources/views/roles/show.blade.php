<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">Role Details</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <h4 class="mb-3">{{ $role->name }}</h4>

                <div class="mb-4">
                    <strong>Permissions:</strong>
                    <div class="mt-2 d-flex flex-wrap gap-2">
                        @forelse ($role->permissions as $permission)
                            <span class="badge text-bg-secondary">{{ $permission->name }}</span>
                        @empty
                            <span class="text-muted">No permissions assigned.</span>
                        @endforelse
                    </div>
                </div>

                <div>
                    <strong>Users:</strong>
                    <ul class="mt-2 mb-0">
                        @forelse ($role->users as $user)
                            <li>{{ $user->name }} ({{ $user->email }})</li>
                        @empty
                            <li class="text-muted">No users assigned.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>