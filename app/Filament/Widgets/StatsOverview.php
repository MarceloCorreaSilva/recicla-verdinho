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
        return [
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
        ];
    }
}
