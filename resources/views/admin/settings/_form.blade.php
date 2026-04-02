<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Key</label>
        <input type="text" name="key" value="{{ old('key', $setting->key ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Type</label>
        <select name="type" class="form-select" required>
            @foreach ($types as $value => $label)
                <option value="{{ $value }}" @selected(old('type', $setting->type ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Group</label>
        <input type="text" name="group_name" value="{{ old('group_name', $setting->group_name ?? 'general') }}" class="form-control" required>
    </div>

    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="autoload" value="1" id="autoload" @checked(old('autoload', $setting->autoload ?? true))>
            <label class="form-check-label" for="autoload">Autoload</label>
        </div>
    </div>

    <div class="col-12">
        <label class="form-label">Value</label>
        <textarea name="value" rows="4" class="form-control">{{ old('value', isset($setting) ? (is_array($setting->value) ? json_encode($setting->value) : $setting->value) : '') }}</textarea>
    </div>
</div>