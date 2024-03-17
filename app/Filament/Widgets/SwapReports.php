<?php

namespace App\Filament\Widgets;

use App\Models\City;
use App\Models\Swap;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SwapReports extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['Secretario', 'Gerente', 'Coordenador']);
    }

    protected function getTableHeader(): View|Htmlable|null
    {
        return view('admin.widgets.swap');
    }

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->hasRole(['Secretario'])) {
            return Swap::whereHas(
                relation: 'student',
                callback: fn (Builder $query) => $query->whereHas(
                    relation: 'school',
                    callback: fn (Builder $query) => $query->whereHas(
                        relation: 'city',
                        callback: fn (Builder $query) => $query
                            ->where('cities.secretary_id', auth()->user()->id)
                    )
                )
            )
                ->groupBy('swaps.date')
                ->orderBy('swaps.date', 'desc');
        }
        if (auth()->user()->hasRole(['Gerente'])) {
            return Swap::whereHas(
                relation: 'student',
                callback: fn (Builder $query) => $query->whereHas(
                    relation: 'school',
                    callback: fn (Builder $query) => $query
                        ->where('schools.manager_id', auth()->user()->id)
                )
            )
                ->groupBy('swaps.date')
                ->orderBy('swaps.date', 'desc');
        }
        if (auth()->user()->hasRole(['Coordenador'])) {
            return Swap::whereHas(
                relation: 'student',
                callback: fn (Builder $query) => $query->whereHas(
                    relation: 'school',
                    callback: fn (Builder $query) => $query
                        ->where('schools.coordinator_id', auth()->user()->id)
                )
            )
                ->groupBy('swaps.date')
                ->orderBy('swaps.date', 'desc');
        }

        // return Swap::query()
        //     ->join('students', 'students.id', '=', 'swaps.student_id')
        //     ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
        //     ->join('schools', 'schools.id', '=', 'school_classes.school_id')
        //     ->where('schools.manager_id', '=', auth()->user()->id)
        //     ->orWhere('schools.coordinator_id', '=', auth()->user()->id)
        //     ->groupBy('swaps.date')
        //     ->orderBy('swaps.date', 'desc');
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
