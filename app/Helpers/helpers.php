<?php

use App\Services\SettingService;

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null)
    {
        return app(SettingService::class)->get($key, $default);
    }
}