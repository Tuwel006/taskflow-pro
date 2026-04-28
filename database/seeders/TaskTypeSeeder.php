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
            ['name' => 'Task', 'description' => 'A task to be completed.', 'is_active' => true, 'icon' => 'task'],
            ['name' => 'Bug', 'description' => 'A bug to be fixed.', 'is_active' => true, 'icon' => 'bug'],
            ['name' => 'Feature', 'description' => 'A new feature to be added.', 'is_active' => true, 'icon' => 'feature'],
            ['name' => 'Improvement', 'description' => 'An improvement to be made.', 'is_active' => true, 'icon' => 'improvement'],
            ['name' => 'Documentation', 'description' => 'Documentation to be written.', 'is_active' => true, 'icon' => 'documentation'],
        ];

        foreach ($taskTypes as $taskType) {
            if (! TaskType::where('name', $taskType['name'])->exists()) {
                TaskType::create($taskType);
            }
        }
    }
}
