<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $schoolClasses = SchoolClass::all();

        // foreach ($schoolClasses as $schoolClass) {

        //     for ($i = 0; $i <= 10; $i++) {
        //         Student::factory()->create([
        //             'school_class_id' => $schoolClass->id,
        //             'name' => Fake()->firstName . ' ' . Fake()->lastName
        //         ]);
        //     }
        // }

        $students = File::json(public_path('data/students.json'));
        foreach ($students as $student) {
            Student::factory()->create([
                'school_id' => $student['school_id'],
                'school_class_id' => $student['school_class_id'],
                'registration' => $student['matric'],
                'name' => $student['nome'],
                'gender' => $student['sexo']
            ]);
        }
    }
}
