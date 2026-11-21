<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            RoleSeeder::class,
            OperatingSystemSeeder::class
        );

        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => 123,
            'role_id' => 1,
        ]);
    }
}
