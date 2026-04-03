<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-bold">
                Dashboard
            </h2>

            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                Edit Profile
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <x-flash-message />

        <div class="row g-4">

            {{-- User Info --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-1">{{ auth()->user()->email }}</p>

                        <span class="badge bg-secondary">
                            {{ auth()->user()->roles->pluck('name')->join(', ') ?: 'No Role' }}
                        </span>

                        <div class="mt-3">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Quick Actions</h5>

                        <div class="row g-3">

                            {{-- Author --}}
                            @role('Author')
                                <div class="col-md-4">
                                    <a href="{{ route('author.posts.index') }}" class="btn btn-outline-dark w-100">
                                        My Posts
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="{{ route('author.posts.create') }}" class="btn btn-outline-success w-100">
                                        Create Post
                                    </a>
                                </div>
                            @endrole

                            {{-- Editor --}}
                            @role('Editor|Super Admin')
                                <div class="col-md-4">
                                    <a href="{{ route('editor.reviews.index') }}" class="btn btn-outline-warning w-100">
                                        Review Posts
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="{{ route('editor.comments.index') }}" class="btn btn-outline-info w-100">
                                        Moderate Comments
                                    </a>
                                </div>
                            @endrole

                            {{-- Super Admin --}}
                            @role('Super Admin')
                                <div class="col-md-4">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100">
                                        Manage Users
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary w-100">
                                        Manage Roles
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-dark w-100">
                                        Site Settings
                                    </a>
                                </div>
                            @endrole

                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Welcome Card --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Welcome, {{ auth()->user()->name }} 👋</h5>
                        <p class="text-muted mb-0">
                            You are logged in as 
                            <strong>{{ auth()->user()->roles->pluck('name')->join(', ') }}</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>