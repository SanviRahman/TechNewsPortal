<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Permission Name</label>
        <input type="text" name="name" value="{{ old('name', $permission->name ?? '') }}" class="form-control" required>
    </div>
</div>