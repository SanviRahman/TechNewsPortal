<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Tech News Portal',
                'type' => 'string',
                'group_name' => 'general',
                'autoload' => true,
            ],
            [
                'key' => 'site_email',
                'value' => 'admin@example.com',
                'type' => 'string',
                'group_name' => 'general',
                'autoload' => true,
            ],
            [
                'key' => 'site_phone',
                'value' => '+8801700000000',
                'type' => 'string',
                'group_name' => 'general',
                'autoload' => true,
            ],
            [
                'key' => 'posts_per_page',
                'value' => '10',
                'type' => 'integer',
                'group_name' => 'general',
                'autoload' => true,
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group_name' => 'general',
                'autoload' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}