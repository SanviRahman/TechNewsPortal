<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    protected static array $cache = [];

    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, self::$cache)) {
            return self::$cache[$key];
        }

        $setting = Setting::where('key', $key)->first();

        return self::$cache[$key] = $setting?->value ?? $default;
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string $group
     * @return Setting
     */
/*******  ad235e19-4a7a-4a85-b08f-cb3bec781615  *******/    public function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): Setting
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group_name' => $group,
                'autoload' => true,
            ]
        );
    }

    public function all(): array
    {
        return Setting::where('autoload', true)
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }
}