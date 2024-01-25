<?php

namespace App\Filament\Widgets;

use App\Models\School;
use Barryvdh\DomPDF\Facade\Pdf;
use Closure;
use Filament\Pages\Actions\CreateAction;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;

class SchoolReports extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['Developer', 'Admin']);
    }

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
            // Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('city.name')
                ->label('Cidade')
                // ->numeric()
                ->searchable()
                ->sortable(),

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
                ->openUrlInNewTab(),

            Tables\Actions\Action::make('Pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-s-download')
                ->action(function (School $record) {
                    $report = [];
                    $reportAnual = [];
                    $school = School::find($record->id);
                    $school_classes = $school->school_classes()
                        ->selectRaw('
                            strftime("%Y", swaps.date) as year,
                            strftime("%m", swaps.date) as month,
                            strftime("%d", swaps.date) as day,
                            strftime("%d/%m/%Y", swaps.date) as data,

                            SUM(swaps.pet_bottles) as total_pet_bottles,
                            SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                            SUM(swaps.tetra_pak) as total_tetra_pak,
                            SUM(swaps.aluminum_cans) as total_aluminum_cans,
                            SUM(swaps.green_coin) as total_green_coin
                        ')

                        ->join('students', 'students.school_class_id', '=', 'school_classes.id')
                        ->join('swaps', 'swaps.student_id', '=', 'students.id')
                        ->orderBy('swaps.date', 'asc')
                        ->groupBy('year', 'month', 'day')
                        ->get();

                    $school_classes->each(function ($item) use (&$report) {
                        $report[intval($item->year)][intval($item->month)][intval($item->day)] = [
                            'data' => $item->data,
                            'pet_bottles' => $item->total_pet_bottles,
                            'packaging_of_cleaning_materials' => $item->total_packaging_of_cleaning_materials,
                            'tetra_pak' => $item->total_tetra_pak,
                            'aluminum_cans' => $item->total_aluminum_cans,
                            'green_coin' => $item->total_green_coin,
                        ];
                    });

                    $school_classes->each(function ($item) use (&$reportAnual) {
                        $reportAnual[intval($item->year)]['pet_bottles'] = 0;
                        $reportAnual[intval($item->year)]['packaging_of_cleaning_materials'] = 0;
                        $reportAnual[intval($item->year)]['tetra_pak'] = 0;
                        $reportAnual[intval($item->year)]['aluminum_cans'] = 0;
                        $reportAnual[intval($item->year)]['green_coin'] = 0;
                    });

                    $school_classes->each(function ($item) use (&$reportAnual) {

                        $reportAnual[intval($item->year)] = [
                            'pet_bottles' => $reportAnual[intval($item->year)]['pet_bottles'] + $item->total_pet_bottles,
                            'packaging_of_cleaning_materials' => $reportAnual[intval($item->year)]['packaging_of_cleaning_materials'] + $item->total_packaging_of_cleaning_materials,
                            'tetra_pak' => $reportAnual[intval($item->year)]['tetra_pak'] + $item->total_tetra_pak,
                            'aluminum_cans' => $reportAnual[intval($item->year)]['aluminum_cans'] + $item->total_aluminum_cans,
                            'green_coin' => $reportAnual[intval($item->year)]['green_coin'] + $item->total_green_coin,
                        ];
                    });

                    return response()->streamDownload(function () use ($record, $school, $report, $reportAnual) {
                        echo Pdf::loadHtml(
                            Blade::render('school-pdf', ['school' => $school, 'report' => $report, 'reportAnual' => $reportAnual])
                        )->stream();
                    }, $record->name . '.pdf');
                }),

            Tables\Actions\Action::make('Visualisar')
                ->icon('heroicon-o-document-search')
                ->action(function (School $record) {
                })
                ->modalHeading(
                    // function ($arguments, $action, $record) {
                    //     return $record->name;
                    // }
                    // fn (School $record) => $record->name
                    'Relatório Geral'
                )
                ->modalContent(function ($arguments, $action, $record) {
                    // Log::info($action->getname(), [$arguments, $action->getArguments()]);
                    // $arguments = Arr::last($this->mountedActionsArguments);

                    $arguments = $action->getArguments();

                    return view('reports.school.test', [
                        'params' => 'params',
                        'arguments' => $arguments,
                        'record' => $record,
                        'report' => $record->reportToYears()
                    ]);
                })
        ];
    }
}
