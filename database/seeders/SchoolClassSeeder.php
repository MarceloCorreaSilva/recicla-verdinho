<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $schools = School::all();

        // ESCOLA MUNICIPAL CRISTALINO
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL CRISTALINO')->first(),
            'name' => '4º Ano 1-A',
            'year' => 2024,
            'active' => true
        ]);
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL CRISTALINO')->first(),
            'name' => '4º Ano 1-B',
            'year' => 2024,
            'active' => true
        ]);
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL CRISTALINO')->first(),
            'name' => '4º Ano 2-C',
            'year' => 2024,
            'active' => true
        ]);
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL CRISTALINO')->first(),
            'name' => '5º Ano 2-A',
            'year' => 2024,
            'active' => true
        ]);

        // ESCOLA MUNICIPAL ERMINDO MENDEL
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL ERMINDO MENDEL')->first(),
            'name' => '4º Ano 1-A',
            'year' => 2024,
            'active' => true
        ]);
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL ERMINDO MENDEL')->first(),
            'name' => '4º Ano 2-B',
            'year' => 2024,
            'active' => true
        ]);
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL ERMINDO MENDEL')->first(),
            'name' => '4º Ano 3-C',
            'year' => 2024,
            'active' => true
        ]);

        // ESCOLA MUNICIPAL GUARUJA
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL GUARUJA')->first(),
            'name' => '5º Ano 6-A',
            'year' => 2024,
            'active' => true
        ]);
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL GUARUJA')->first(),
            'name' => '5º Ano 7-B',
            'year' => 2024,
            'active' => true
        ]);
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL GUARUJA')->first(),
            'name' => '5º Ano 10-C',
            'year' => 2024,
            'active' => true
        ]);
        SchoolClass::factory()->create([
            'school_id' => School::where('name', '=', 'ESCOLA MUNICIPAL GUARUJA')->first(),
            'name' => '5º Ano 8-D',
            'year' => 2024,
            'active' => true
        ]);


        // foreach ($schools as $school) {
        //     SchoolClass::factory()->create([
        //         'school_id' => $school->id,
        //         'name' => '5º Ano A',
        //         'year' => 2023,
        //         'active' => true
        //     ]);

        //     // SchoolClass::factory()->create([
        //     //     'school_id' => $school->id,
        //     //     'name' => '5º Ano B',
        //     //     'year' => 2023,
        //     //     'active' => true
        //     // ]);

        //     // SchoolClass::factory()->create([
        //     //     'school_id' => $school->id,
        //     //     'name' => '5º Ano C',
        //     //     'year' => 2023,
        //     //     'active' => true
        //     // ]);
        // }
    }
}
