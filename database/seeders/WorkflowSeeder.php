<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use App\Models\Teams;
use App\Models\Workflow;
use Illuminate\Database\Seeder;

class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Teams::all();
        $todo = TaskStatus::where('name', 'To Do')->first();
        $inProgress = TaskStatus::where('name', 'In Progress')->first();
        $review = TaskStatus::where('name', 'Review')->first();
        $done = TaskStatus::where('name', 'Done')->first();

        if (!$todo || !$inProgress || !$review || !$done) {
            return;
        }

        foreach ($teams as $team) {
            // Linear transitions
            Workflow::create(['team_id' => $team->id, 'from_status_id' => $todo->id, 'to_status_id' => $inProgress->id]);
            Workflow::create(['team_id' => $team->id, 'from_status_id' => $inProgress->id, 'to_status_id' => $review->id]);
            Workflow::create(['team_id' => $team->id, 'from_status_id' => $review->id, 'to_status_id' => $done->id]);
            
            // Allow moving back to In Progress from Review
            Workflow::create(['team_id' => $team->id, 'from_status_id' => $review->id, 'to_status_id' => $inProgress->id]);
        }
    }
}
