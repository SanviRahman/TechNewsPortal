<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0 section-title">User Details</h2></x-slot>
    <div class="container">
        <x-flash-message />
        <div class="card page-card">
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-md-3">Name</dt>
                    <dd class="col-md-9">{{ $user->name }}</dd>

                    <dt class="col-md-3">Username</dt>
                    <dd class="col-md-9">{{ $user->username ?: '-' }}</dd>

                    <dt class="col-md-3">Email</dt>
                    <dd class="col-md-9">{{ $user->email }}</dd>

                    <dt class="col-md-3">Status</dt>
                    <dd class="col-md-9">{{ ucfirst($user->status) }}</dd>

                    <dt class="col-md-3">Roles</dt>
                    <dd class="col-md-9">{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</dd>

                    <dt class="col-md-3">Bio</dt>
                    <dd class="col-md-9">{{ $user->bio ?: '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>