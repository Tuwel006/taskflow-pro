<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teams;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the main Admin User
        $admin = User::updateOrCreate(
            ['email' => 'tuwelshaikh006@gmail.com'],
            [
                'name' => 'Tuwel Shaikh',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'type' => 1,
                'is_active' => true,
                'phone' => '1234567890',
                'address' => '123 Admin Lane',
                'avatar' => 'error_testing_url.jpg', // Invalid URL to trigger fallback
            ]
        );

        // 2. Create other beautiful meaningful users
        $names = [
            'Alice Johnson', 'Bob Williams', 'Charlie Brown', 'Diana Prince', 
            'Evan Tracker', 'Fiona Gallagher', 'George Miller', 'Hannah Baker'
        ];

        $users = collect([$admin]);
        foreach ($names as $name) {
            $email = strtolower(explode(' ', $name)[0]) . '@example.com';
            $users->push(User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('123456'),
                    'role' => 'user',
                    'type' => rand(1,2),
                    'is_active' => true,
                    'phone' => '0987654321',
                    'address' => 'Sample Address',
                    'avatar' => 'wrong_url.jpg', // Invalid URL to test fallback
                ]
            ));
        }

        // 3. Call existing seeders
        $this->call([
            TaskStatusSeeder::class,
            TaskTypeSeeder::class,
            TeamsSeeder::class,
            StageSeeder::class,
            TaskSeeder::class,
            WorkflowSeeder::class,
        ]);

        // 4. Attach users to teams
        $teams = Teams::all();
        foreach ($users as $user) {
            if ($user->id === $admin->id) {
                // Admin gets all teams
                $user->teams()->attach($teams->pluck('id'));
            } else {
                // Other users get 2 to 4 random teams
                $user->teams()->attach($teams->random(rand(2, 4))->pluck('id'));
            }
        }
    }
}
