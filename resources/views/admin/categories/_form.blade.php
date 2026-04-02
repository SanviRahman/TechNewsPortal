<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Category Name</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-select">
            <option value="1" @selected((string) old('is_active', isset($category) ? (int) $category->is_active : 1) === '1')>Active</option>
            <option value="0" @selected((string) old('is_active', isset($category) ? (int) $category->is_active : 1) === '0')>Inactive</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
</div>