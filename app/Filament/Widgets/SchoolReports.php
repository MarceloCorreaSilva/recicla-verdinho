<?php

namespace App\Filament\Widgets;

use App\Models\School;
use Closure;
use Filament\Pages\Actions\CreateAction;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class SchoolReports extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getTableHeader(): View|Htmlable|null
    {
        return view('admin.widgets.school');
    }

    protected function getTableQuery(): Builder
    {
        return School::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label('Escola'),
            Tables\Columns\TextColumn::make('total_materials')
                ->sortable()
                ->label('Total de Materiais'),
            Tables\Columns\TextColumn::make('total_green_coins')
                ->sortable()
                ->label('Total de Verdinhos'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('Relatório')
                ->icon('heroicon-o-document-download')
                ->url(fn (School $record) => route('school.pdf.download', $record))
                ->openUrlInNewTab()
        ];
    }
}
