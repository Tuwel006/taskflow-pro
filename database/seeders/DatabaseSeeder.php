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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Tuwel Shaikh',
            'email' => 'tuwel@admin.com',
            'password' => 'admin123',
            'role' => 'admin',
            'type' => 1,
            'is_active' => true,
            'phone' => '1234567890',
            'address' => '123 Main St',
            'avatar' => 'https://via.placeholder.com/150',
        ]);

        $this->call([
            TaskStatusSeeder::class,
            TaskTypeSeeder::class,
            TeamsSeeder::class,
        ]);
    }
}
