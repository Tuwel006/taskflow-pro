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
            ['name' => 'To Do', 'color' => '#64748b'],
            ['name' => 'In Progress', 'color' => '#3b82f6'],
            ['name' => 'Review', 'color' => '#f59e0b'],
            ['name' => 'Done', 'color' => '#10b981'],
        ];

        foreach ($statuses as $status) {
            TaskStatus::create($status);
        }
    }
}