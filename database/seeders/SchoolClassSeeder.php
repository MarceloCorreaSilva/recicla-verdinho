<?php

namespace Database\Seeders;

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
        SchoolClass::factory()->create([
            'school_id' => 1,
            'name' => '5A',
            'year' => 2023,
            'active' => true
        ]);

        SchoolClass::factory()->create([
            'school_id' => 1,
            'name' => '5B',
            'year' => 2023,
            'active' => true
        ]);

        SchoolClass::factory()->create([
            'school_id' => 1,
            'name' => '5C',
            'year' => 2023,
            'active' => true
        ]);
    }
}
