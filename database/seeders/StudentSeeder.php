<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolClasses = SchoolClass::all();

        foreach ($schoolClasses as $schoolClass) {

            for ($i = 0; $i <= 10; $i++) {
                Student::factory()->create([
                    'school_class_id' => $schoolClass->id,
                    'name' => Fake()->firstName . ' ' . Fake()->lastName
                ]);
            }
        }
    }
}
