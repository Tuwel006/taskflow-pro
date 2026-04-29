<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Database\Seeder;

class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $todo = TaskStatus::where('name', 'To Do')->first();
        $inProgress = TaskStatus::where('name', 'In Progress')->first();
        $review = TaskStatus::where('name', 'Review')->first();
        $done = TaskStatus::where('name', 'Done')->first();

        if (!$todo || !$inProgress || !$review || !$done) {
            return;
        }

        foreach ($projects as $project) {
            // Linear transitions
            Workflow::create(['project_id' => $project->id, 'from_status_id' => $todo->id, 'to_status_id' => $inProgress->id]);
            Workflow::create(['project_id' => $project->id, 'from_status_id' => $inProgress->id, 'to_status_id' => $review->id]);
            Workflow::create(['project_id' => $project->id, 'from_status_id' => $review->id, 'to_status_id' => $done->id]);
            
            // Allow moving back to In Progress from Review
            Workflow::create(['project_id' => $project->id, 'from_status_id' => $review->id, 'to_status_id' => $inProgress->id]);
        }
    }
}
