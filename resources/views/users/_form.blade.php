@php
    $selectedRoles = old('roles', isset($user) ? $user->roles->pluck('name')->toArray() : []);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Username</label>
        <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Avatar</label>
        <input type="text" name="avatar" value="{{ old('avatar', $user->avatar ?? '') }}" class="form-control" placeholder="Optional image path">
    </div>

    <div class="col-md-6">
        <label class="form-label">Password {{ isset($user) ? '(Optional)' : '' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="active" @selected(old('status', $user->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $user->status ?? '') === 'inactive')>Inactive</option>
            <option value="banned" @selected(old('status', $user->status ?? '') === 'banned')>Banned</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Roles</label>
        <div class="row g-2">
            @foreach ($roles as $role)
                <div class="col-6">
                    <div class="form-check border rounded p-2">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" @checked(in_array($role->name, $selectedRoles))>
                        <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-12">
        <label class="form-label">Bio</label>
        <textarea name="bio" rows="3" class="form-control">{{ old('bio', $user->bio ?? '') }}</textarea>
    </div>
</div>