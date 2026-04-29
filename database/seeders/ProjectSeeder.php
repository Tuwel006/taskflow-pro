<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            ['name' => 'Project Phoenix', 'prefix' => 'PHX', 'description' => 'Revitalization of the core infrastructure.'],
            ['name' => 'Quantum Leap', 'prefix' => 'QLP', 'description' => 'Advanced research into computing and AI.'],
            ['name' => 'Starlight System', 'prefix' => 'SLS', 'description' => 'Global communication and satellite tracking.'],
            ['name' => 'Blue Horizon', 'prefix' => 'BHZ', 'description' => 'Next-gen cloud storage and networking solutions.'],
            ['name' => 'Iron Fortress', 'prefix' => 'IFT', 'description' => 'Cybersecurity and threat detection platform.'],
            ['name' => 'Silver Stream', 'prefix' => 'SST', 'description' => 'Real-time data processing and analytics.'],
            ['name' => 'Green Valley', 'prefix' => 'GVY', 'description' => 'Sustainability and environmental monitoring.'],
            ['name' => 'Solar Pulse', 'prefix' => 'SPL', 'description' => 'Renewable energy optimization and distribution.'],
            ['name' => 'Cyber Core', 'prefix' => 'CCX', 'description' => 'Digital transformation and automation tools.'],
            ['name' => 'Titan Forge', 'prefix' => 'TTF', 'description' => 'Heavy-duty manufacturing and logistics system.'],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['prefix' => $project['prefix']],
                $project
            );
        }
    }
}
