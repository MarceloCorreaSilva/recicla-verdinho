<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\Movement;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Swap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class SwapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-01-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-02-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-03-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-04-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-05-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-06-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-07-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-08-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-09-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-10-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-11-01');
            $this->updateMovement($student, $swap);
        }

        foreach ($students as $student) {
            $swap = $this->createSwap($student, '2023-12-01');
            $this->updateMovement($student, $swap);
        }
    }

    public function createSwap(Student $student, String $date): Swap
    {
        $pet_bottles = Fake()->numberBetween(10, 50);
        $packaging_of_cleaning_materials = Fake()->numberBetween(10, 50);
        $tetra_pak = Fake()->numberBetween(10, 50);
        $aluminum_cans = Fake()->numberBetween(10, 50);

        $green_coin = ($pet_bottles + $packaging_of_cleaning_materials + $tetra_pak + $aluminum_cans) / 10;

        $swap = Swap::factory()->create([
            'student_id' => $student->id,
            'date' => Date($date),
            'pet_bottles' => $pet_bottles,
            'packaging_of_cleaning_materials' => $packaging_of_cleaning_materials,
            'tetra_pak' => $tetra_pak,
            'aluminum_cans' => $aluminum_cans,
            'green_coin' => floor($green_coin)
        ]);

        return $swap;
    }

    public function updateMovement(Student $student, Swap $swap): void
    {
        // $student = Student::all()->where('id', $student->id)->first();
        $schoolClass = SchoolClass::all()->where('id', $student->school_class_id)->first();
        $school = School::all()->where('id', $schoolClass->school_id)->first();

        $financial = Financial::all()->where('school_id', $school->id)->first();

        $movement = Movement::create([
            'financial_id' => $financial->id,
            'student_id' => $student->id,
            'date' => $swap->date,
            'status' => 'output',
            'value' => $swap->green_coin
        ]);

        $financial->balance = ($financial->balance - $movement->value);
        $financial->save();
    }
}
