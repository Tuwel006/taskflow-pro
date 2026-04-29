<?php

namespace Database\Seeders;

use App\Constants\TaskPriority;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\Teams;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $teams = Teams::all();
        $statuses = TaskStatus::all();
        $types = TaskType::all();
        $priorities = [TaskPriority::LOW, TaskPriority::MEDIUM, TaskPriority::HIGH, TaskPriority::URGENT];

        if ($users->isEmpty() || $teams->isEmpty() || $statuses->isEmpty() || $types->isEmpty()) {
            return;
        }

        $tasks = [
            [
                'title' => 'Fix Header Alignment',
                'description' => 'The header alignment is off on mobile devices.',
            ],
            [
                'title' => 'Implement User Authentication',
                'description' => 'Set up socialite for Google login.',
            ],
            [
                'title' => 'Optimize Database Queries',
                'description' => 'Slow queries detected on the dashboard.',
            ],
            [
                'title' => 'Update Documentation',
                'description' => 'Add API documentation for the new endpoints.',
            ],
            [
                'title' => 'Bug: Avatar Fallback',
                'description' => 'Avatar fallback is not working correctly.',
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'task_status_id' => $statuses->random()->id,
                'task_type_id' => $types->random()->id,
                'priority' => $priorities[array_rand($priorities)],
                'team_id' => $teams->random()->id,
                'assigned_to' => $users->random()->id,
                'created_by' => $users->first()->id,
                'due_date' => now()->addDays(rand(1, 10)),
            ]));
        }
    }
}
