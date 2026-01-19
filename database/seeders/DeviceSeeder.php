<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('devices')->insert([
            'device_name' => 'Device 1',
            'api_key' => 'device1apikey',
            'location' => 'Gerbang Sekolah',
            'is_active' => true,
        ]);
    }
}
