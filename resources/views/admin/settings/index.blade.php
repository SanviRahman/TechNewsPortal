<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 section-title">Settings</h2>
            <a href="{{ route('admin.settings.create') }}" class="btn btn-primary">Create Setting</a>
        </div>
    </x-slot>

    <div class="container">
        <x-flash-message />

        <div class="card page-card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="search" value="{{ $search ?? request('search') }}" class="form-control" placeholder="Search settings">
                    </div>
                    <div class="col-md-5">
                        <select name="group" class="form-select">
                            <option value="">All Groups</option>
                            @foreach ($groups as $groupItem)
                                <option value="{{ $groupItem }}" @selected(($group ?? request('group')) === $groupItem)>{{ $groupItem }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card page-card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Quick Bulk Update</h5>
                <form method="POST" action="{{ route('admin.settings.bulk-update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        @foreach ($settings as $setting)
                            <div class="col-md-6">
                                <label class="form-label">{{ $setting->key }}</label>
                                <input type="hidden" name="settings[{{ $loop->index }}][id]" value="{{ $setting->id }}">
                                <input type="text" name="settings[{{ $loop->index }}][value]"
                                       value="{{ is_array($setting->value) ? json_encode($setting->value) : $setting->value }}"
                                       class="form-control">
                            </div>
                        @endforeach
                    </div>

                    @if ($settings->count())
                        <div class="mt-3">
                            <button class="btn btn-success">Save All Visible Settings</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="card page-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Type</th>
                                <th>Group</th>
                                <th>Autoload</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($settings as $setting)
                                <tr>
                                    <td>{{ $setting->key }}</td>
                                    <td>{{ is_array($setting->value) ? json_encode($setting->value) : $setting->value }}</td>
                                    <td>{{ $setting->type }}</td>
                                    <td>{{ $setting->group_name }}</td>
                                    <td>{{ $setting->autoload ? 'Yes' : 'No' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.settings.show', $setting) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('admin.settings.edit', $setting) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this setting?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4 text-muted">No settings found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">{{ $settings->links() }}</div>
    </div>
</x-app-layout>