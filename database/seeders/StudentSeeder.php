<?php

namespace Database\Seeders;

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
        for ($i = 0; $i <= 30; $i++) {
            Student::factory()->create([
                'school_class_id' => 1,
                'name' => Fake()->firstName . ' ' . Fake()->lastName
            ]);
        }
    }
}
