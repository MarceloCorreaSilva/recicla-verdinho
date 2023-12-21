<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Swap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SwapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();

        foreach ($students as $student) {
            $pet_bottles = Fake()->numberBetween(10, 50);
            $packaging_of_cleaning_materials = Fake()->numberBetween(10, 50);
            $tetra_pak = Fake()->numberBetween(10, 50);
            $aluminum_cans = Fake()->numberBetween(10, 50);

            $green_coin = ($pet_bottles + $packaging_of_cleaning_materials + $tetra_pak + $aluminum_cans) / 10;

            Swap::factory()->create([
                'student_id' => $student->id,
                'date' => Date('2023-01-01'),
                'pet_bottles' => $pet_bottles,
                'packaging_of_cleaning_materials' => $packaging_of_cleaning_materials,
                'tetra_pak' => $tetra_pak,
                'aluminum_cans' => $aluminum_cans,
                'green_coin' => floor($green_coin)
            ]);
        }
    }
}
