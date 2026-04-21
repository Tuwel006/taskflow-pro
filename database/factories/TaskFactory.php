<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(1),
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'priority' => $this->faker->randomElement(['Urgent', 'High', 'Medium', 'Low']),
            'task_status_id' => \App\Models\TaskStatus::inRandomOrder()->first()?->id ?? 1,
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id ?? 1,
            'assigned_to' => \App\Models\User::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
