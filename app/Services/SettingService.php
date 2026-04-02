<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    protected static array $cache = [];

    public function get(string $key, mixed $default = null): mixed
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $setting = Setting::where('key', $key)->first();

        return self::$cache[$key] = $setting?->value ?? $default;
    }

    public function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): Setting
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group_name' => $group,
            ]
        );
    }

    public function all(): array
    {
        return Setting::autoload()
            ->pluck('value', 'key')
            ->toArray();
    }
}