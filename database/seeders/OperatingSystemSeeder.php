<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('operating_systems')->insert([
            ['os_name' => 'Windows', 'created_at' => now(), 'updated_at' => now()],
            ['os_name' => 'Linux', 'created_at' => now(), 'updated_at' => now()],
            ['os_name' => 'macOs', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
