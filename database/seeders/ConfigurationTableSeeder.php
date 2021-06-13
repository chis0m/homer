<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('configurations')->insert(
            [
                [
                    'title' => 'Property Expiry Notification Maximum Count',
                    'slug' => 'property_expiry_notification_max_count',
                    'default' => 4,
                    'value' => 5,
                    'unit' => null
                ],
                [
                    'title' => 'Property Expiry Notification Time Interval',
                    'slug' => 'property_expiry_notification_time_interval',
                    'default' => 7,
                    'value' => 7,
                    'unit' => 'hr'
                ]
            ]
        );
    }
}
