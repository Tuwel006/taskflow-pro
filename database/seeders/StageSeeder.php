<?php

namespace Database\Seeders;

use App\Models\Stage;
use App\Models\TaskStatus;
use App\Models\Project;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $statuses = TaskStatus::all();

        // For each project, create a workflow with all statuses in order
        foreach ($projects as $project) {
            $position = 1;
            foreach ($statuses as $status) {
                Stage::create([
                    'project_id' => $project->id,
                    'status_id' => $status->id,
                    'position' => $position,
                ]);
                $position++;
            }
        }
    }
}
