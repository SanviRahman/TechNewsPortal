@php
    $selectedPermissions = old('permissions', isset($role) ? $role->permissions->pluck('name')->toArray() : []);
@endphp

<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Role Name</label>
        <input type="text" name="name" value="{{ old('name', $role->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-12">
        <label class="form-label">Permissions</label>
        <div class="row g-2">
            @foreach ($permissions as $permission)
                <div class="col-md-4 col-sm-6">
                    <div class="form-check border rounded p-2">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" @checked(in_array($permission->name, $selectedPermissions))>
                        <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>