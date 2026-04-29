<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'To Do'],
            ['name' => 'In Progress'],
            ['name' => 'Review'],
            ['name' => 'Done'],
        ];

        foreach ($statuses as $status) {
            TaskStatus::updateOrCreate(
                ['name' => $status['name']],
                $status
            );
        }
    }
}