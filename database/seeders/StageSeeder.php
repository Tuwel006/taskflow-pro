<?php

namespace Database\Seeders;

use App\Models\Stage;
use App\Models\TaskStatus;
use App\Models\Teams;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Teams::all();
        $statuses = TaskStatus::all();

        // For each team, create a workflow with all statuses in order
        foreach ($teams as $team) {
            $position = 1;
            foreach ($statuses as $status) {
                Stage::create([
                    'team_id' => $team->id,
                    'status_id' => $status->id,
                    'position' => $position,
                ]);
                $position++;
            }
        }
    }
}
