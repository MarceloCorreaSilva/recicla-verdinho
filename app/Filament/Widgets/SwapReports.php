<?php

namespace App\Filament\Widgets;

use App\Models\Swap;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class SwapReports extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->hasRole('Coordenador');
    }

    protected function getTableHeader(): View|Htmlable|null
    {
        return view('admin.widgets.swap');
    }

    protected function getTableQuery(): Builder
    {
        return Swap::query()
            ->join('students', 'students.id', '=', 'swaps.student_id')
            ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
            ->join('schools', 'schools.id', '=', 'school_classes.school_id')
            ->where('schools.id', '=', auth()->user()->coordinator->id)
            ->groupBy('swaps.date')
            ->orderBy('swaps.date', 'desc');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('date')
                ->dateTime('d/m/Y')
                ->sortable()
                ->label('Data da Troca'),
            Tables\Columns\TextColumn::make('total_materials')
                ->sortable()
                ->label('Total de Materiais'),
            Tables\Columns\TextColumn::make('total_green_coins_swap')
                ->sortable()
                ->label('Total de Verdinhos'),
        ];
    }
}
