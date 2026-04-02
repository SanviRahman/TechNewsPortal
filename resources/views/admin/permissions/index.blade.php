<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 section-title">Permissions</h2>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">Create Permission</a>
        </div>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="search" value="{{ $search ?? request('search') }}" class="form-control" placeholder="Search permissions">
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
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.permissions.show', $permission) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this permission?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center py-4 text-muted">No permissions found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">{{ $permissions->links() }}</div>
    </div>
</x-app-layout>