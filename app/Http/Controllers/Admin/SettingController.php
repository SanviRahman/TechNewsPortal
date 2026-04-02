<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingController extends Controller
{
   

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $group = $request->string('group')->toString();

        $settings = Setting::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('key', 'like', "%{$search}%")
                        ->orWhere('value', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('group_name', 'like', "%{$search}%");
                });
            })
            ->when($group, function ($query) use ($group) {
                $query->where('group_name', $group);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $groups = Setting::query()
            ->select('group_name')
            ->distinct()
            ->orderBy('group_name')
            ->pluck('group_name');

        return view('admin.settings.index', compact('settings', 'search', 'group', 'groups'));
    }

    public function create(): View
    {
        $types = $this->types();

        return view('admin.settings.create', compact('types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:150', 'unique:settings,key'],
            'value' => ['nullable'],
            'type' => ['required', Rule::in(array_keys($this->types()))],
            'group_name' => ['required', 'string', 'max:100'],
            'autoload' => ['nullable', 'boolean'],
        ]);

        $validated['autoload'] = $request->boolean('autoload');
        $validated['value'] = $this->normalizeValue(
            $validated['value'] ?? null,
            $validated['type']
        );

        Setting::create($validated);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    public function show(Setting $setting): View
    {
        return view('admin.settings.show', compact('setting'));
    }

    public function edit(Setting $setting): View
    {
        $types = $this->types();

        return view('admin.settings.edit', compact('setting', 'types'));
    }

    public function update(Request $request, Setting $setting): RedirectResponse
    {
        $validated = $request->validate([
            'key' => [
                'required',
                'string',
                'max:150',
                Rule::unique('settings', 'key')->ignore($setting->id),
            ],
            'value' => ['nullable'],
            'type' => ['required', Rule::in(array_keys($this->types()))],
            'group_name' => ['required', 'string', 'max:100'],
            'autoload' => ['nullable', 'boolean'],
        ]);

        $validated['autoload'] = $request->boolean('autoload');
        $validated['value'] = $this->normalizeValue(
            $validated['value'] ?? null,
            $validated['type']
        );

        $setting->update($validated);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Setting updated successfully.');
    }

    public function destroy(Setting $setting): RedirectResponse
    {
        $protectedKeys = [
            'site_name',
            'site_email',
        ];

        if (in_array($setting->key, $protectedKeys, true)) {
            return back()->with('error', 'This setting cannot be deleted.');
        }

        $setting->delete();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Setting deleted successfully.');
    }

    public function bulkUpdate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*.id' => ['required', 'exists:settings,id'],
            'settings.*.value' => ['nullable'],
        ]);

        foreach ($validated['settings'] as $item) {
            $setting = Setting::find($item['id']);

            if (!$setting) {
                continue;
            }

            $setting->update([
                'value' => $this->normalizeValue($item['value'] ?? null, $setting->type),
            ]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    private function types(): array
    {
        return [
            'string' => 'String',
            'integer' => 'Integer',
            'float' => 'Float',
            'boolean' => 'Boolean',
            'json' => 'JSON',
        ];
    }

    private function normalizeValue(mixed $value, string $type): mixed
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0',
            'integer' => is_null($value) || $value === '' ? null : (string) (int) $value,
            'float' => is_null($value) || $value === '' ? null : (string) (float) $value,
            'json' => is_array($value)
                ? json_encode($value, JSON_UNESCAPED_UNICODE)
                : ($this->isJson($value) ? $value : json_encode($value, JSON_UNESCAPED_UNICODE)),
            default => $value,
        };
    }

    private function isJson(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE;
    }
}