<?php

namespace App\Filament\Widgets;

use App\Models\City;
use App\Models\School;
use App\Models\Student;
use App\Models\Swap;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{

    private function formatNumberToStat(string $value): string
    {
        return number_format(intval($value), 0, '.', '.');
    }

    protected function getCards(): array
    {
        if (auth()->user()->hasRole('Coordinator')) {
            $swaps = Swap::selectRaw('
                schools.name,
                SUM(swaps.pet_bottles) as total_pet_bottles,
                SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                SUM(swaps.tetra_pak) as total_tetra_pak,
                SUM(swaps.aluminum_cans) as total_aluminum_cans,
                SUM(swaps.green_coin) as total_green_coin
            ')
                ->join('students', 'students.id', '=', 'swaps.student_id')
                ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                ->where('schools.id', '=', auth()->user()->coordinator->id)

                ->get([
                    'schools.*',
                    'school_classes.*',
                    'students.*',
                    'swaps.*',
                ]);

            $totalSwaps = $swaps[0]['total_pet_bottles'] + $swaps[0]['total_packaging_of_cleaning_materials'] + $swaps[0]['total_tetra_pak'] + $swaps[0]['total_aluminum_cans'];
            $totalGreenCoins = $swaps[0]['total_green_coin'];
        }

        return auth()->user()->hasRole(['Developer', 'Admin'])
            ? [
                Card::make(
                    'Municipios Participantes',
                    $this->formatNumberToStat(City::where('active', true)->count())
                ),

                Card::make(
                    'Escolas Participantes',
                    $this->formatNumberToStat(School::where('active', true)->count())
                ),

                Card::make(
                    'Alunos Atendidos',
                    $this->formatNumberToStat(Student::count())
                ),

                Card::make(
                    'Volumes Trocados',
                    $this->formatNumberToStat(Swap::totalSwaps())
                ),

                Card::make(
                    'Verdinhos Distribuídos',
                    $this->formatNumberToStat(Swap::totalGreenCoins())
                ),
            ] :
            [
                Card::make(
                    'Alunos Atendidos',
                    $this->formatNumberToStat(
                        Student::join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                            ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                            ->where('schools.id', '=', auth()->user()->coordinator->id)
                            // ->join('swaps', 'swaps.student_id', '=', 'students.id')
                            ->get()
                            ->count()
                    ),
                ),
                Card::make(
                    'Volumes Trocados',
                    $this->formatNumberToStat($totalSwaps)
                ),

                Card::make(
                    'Verdinhos Distribuídos',
                    $this->formatNumberToStat($totalGreenCoins)
                ),
            ];
    }
}
