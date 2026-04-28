<?php

namespace Database\Seeders;

use App\Models\Teams;
use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            ['name' => 'Facebook', 'prefix' => 'FB'],
            ['name' => 'Instagram', 'prefix' => 'IG'],
            ['name' => 'Twitter', 'prefix' => 'TW'],
            ['name' => 'LinkedIn', 'prefix' => 'LI'],
            ['name' => 'YouTube', 'prefix' => 'YT'],
            ['name' => 'TikTok', 'prefix' => 'TT'],
            ['name' => 'WhatsApp', 'prefix' => 'WA'],
            ['name' => 'Telegram', 'prefix' => 'TG'],
            ['name' => 'Email', 'prefix' => 'EM'],
            ['name' => 'Phone', 'prefix' => 'PH'],
        ];

        foreach ($teams as $team) {
            Teams::create($team);
        }
    }
}
