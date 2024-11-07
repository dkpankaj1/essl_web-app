<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Setting::create([
            "company_name" => "Cortex It Solution",
            "machine_ip" => "192.168.1.201",
            "serial_no" => "CX456TMW",
            "start_time" => " 08:00:16",
            "punch_start_before" => 60,
            "end_time" => " 14:00:16",
            "punch_end_after" => 120,
        ]);

        $this->call(UserSeeder::class);

    }
}
