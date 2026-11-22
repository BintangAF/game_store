<?php

namespace Database\Seeders;

use App\Models\OperatingSystem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperatingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oses = [
            ['os_name' => 'Windows', 'created_at' => now(), 'updated_at' => now()],
            ['os_name' => 'Linux', 'created_at' => now(), 'updated_at' => now()],
            ['os_name' => 'macOs', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($oses as $os) {
            OperatingSystem::firstOrCreate($os);
        }
    }
}
