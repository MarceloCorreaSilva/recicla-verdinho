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

        SchoolClass::factory()->create([
            'school_id' => 1,
            'name' => '5º Ano A',
            'year' => 2023,
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
