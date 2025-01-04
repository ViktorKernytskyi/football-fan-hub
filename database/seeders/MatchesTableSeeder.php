<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('matches')->insert([
            [
                'team_home' => 'Arsenal',
                'team_away' => 'Chelsi',
                'match_date' => '2025-01-15',
                'stadium' => 'Stadium A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'team_home' => 'Liverpool',
                'team_away' => 'Everton',
                'match_date' => '2025-01-20',
                'stadium' => 'Stadium B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Using a factory to generate 10 random matches - Використання фабрики для створення 10 випадкових матчів
        \App\Models\FootballMatch::factory(10)->create();
    }
}
