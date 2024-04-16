<?php

namespace App\Filament\Widgets;

use App\Models\City;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class CityReports extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['Developer', 'Secretario', 'Gerente', 'Coordenador']);
    }

    protected function getTableHeader(): View|Htmlable|null
    {
        return view('admin.widgets.city');
    }

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->hasRole(['Secretario', 'Gerente', 'Coordenador'])) {
            return City::query()->where('id', Auth::user()->city_id);
        }

        return City::query();
    }

    protected function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 5;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'total_materials';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('state.name')
                ->label('Estado')
                // ->numeric()
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->label('Cidade')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('total_materials')
                ->sortable()
                ->label('Total de Materiais'),
            Tables\Columns\TextColumn::make('total_green_coins')
                ->sortable()
                ->label('Total de Verdinhos'),
        ];
    }
}
