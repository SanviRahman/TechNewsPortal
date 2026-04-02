<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 section-title">Users</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create User</a>
        </div>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="search" value="{{ $search ?? request('search') }}" class="form-control" placeholder="Search by name, email, username">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card page-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($user->status) }}</span></td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">No users found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-app-layout>