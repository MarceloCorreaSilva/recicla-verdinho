<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ESCOLA MUNICIPAL CRISTALINO
        $school01 = School::factory()->create([
            'city_id' => 5100201,
            'name' => 'ESCOLA MUNICIPAL CRISTALINO',
            'limit_per_swap' => 200,
            'project_started' => null,
            'active' => true
        ]);

        Financial::factory()->create([
            'school_id' => $school01->id,
            'balance' => 2000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);

        // ESCOLA MUNICIPAL ERMINDO MENDEL
        $school02 = School::factory()->create([
            'city_id' => 5100201,
            'name' => 'ESCOLA MUNICIPAL ERMINDO MENDEL',
            'limit_per_swap' => 200,
            'project_started' => null,
            'active' => true
        ]);

        Financial::factory()->create([
            'school_id' => $school02->id,
            'balance' => 2000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);

        // ESCOLA MUNICIPAL GUARUJA
        $school03 = School::factory()->create([
            'city_id' => 5100201,
            'name' => 'ESCOLA MUNICIPAL GUARUJA',
            'limit_per_swap' => 200,
            'project_started' => null,
            'active' => true
        ]);

        Financial::factory()->create([
            'school_id' => $school03->id,
            'balance' => 2000,
            'total_items' => 10,
            'total_green_coins' => 1
        ]);
    }
}
