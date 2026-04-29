<?php

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taskTypes = [
            ['name' => 'Bug', 'description' => 'A bug to be fixed.', 'is_active' => true, 'icon' => '<i class="bi bi-bug"></i>', 'color' => '#ef4444'], // Red
            ['name' => 'Feature', 'description' => 'A new feature to be added.', 'is_active' => true, 'icon' => '<i class="bi bi-plus-circle"></i>', 'color' => '#fca5a5'], // Light Red
            ['name' => 'Improvement', 'description' => 'An improvement to be made.', 'is_active' => true, 'icon' => '<i class="bi bi-arrow-up-circle"></i>', 'color' => '#eab308'], // Yellow
            ['name' => 'Documentation', 'description' => 'Documentation to be written.', 'is_active' => true, 'icon' => '<i class="bi bi-file-earmark-text"></i>', 'color' => '#fde047'], // Light Yellow
            ['name' => 'Task', 'description' => 'A task to be completed.', 'is_active' => true, 'icon' => '<i class="bi bi-check2-square"></i>', 'color' => '#22c55e'], // Green
        ];

        foreach ($taskTypes as $taskType) {
            TaskType::updateOrCreate(
                ['name' => $taskType['name']],
                $taskType
            );
        }
    }
}
