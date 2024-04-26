<?php

namespace App\Filament\Widgets;

use App\Models\City;
use App\Models\Swap;
use Barryvdh\DomPDF\Facade\Pdf;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

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

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('Visualisar')
                ->icon('heroicon-o-document-search')
                ->action(function (Swap $record) {
                })
                ->modalHeading(
                    // function ($arguments, $action, $record) {
                    //     return $record->name;
                    // }
                    fn (Swap $record) => "Relatório Por Datas - " . date('d/m/Y', strtotime($record->date))
                    // 'Relatório Por Datas - '
                )
                ->modalContent(function ($arguments, $action, $record) {
                    $arguments = $action->getArguments();
                    $swaps = null;

                    if (Auth::user()->hasRole(['Secretario'])) {
                        $swaps = Swap::whereHas(
                            relation: 'student',
                            callback: fn (Builder $query) => $query->whereHas(
                                relation: 'school',
                                callback: fn (Builder $query) => $query->whereHas(
                                    relation: 'city',
                                    callback: fn (Builder $query) => $query
                                        ->where('cities.secretary_id', Auth::user()->id)
                                )
                            )
                        )
                            ->where('date', $record->date)
                            ->orderBy('green_coin', 'desc')
                            ->get();
                    }

                    if (Auth::user()->hasRole(['Gerente'])) {
                        $swaps = Swap::whereHas(
                            relation: 'student',
                            callback: fn (Builder $query) => $query->whereHas(
                                relation: 'school',
                                callback: fn (Builder $query) => $query
                                    ->where('schools.manager_id', Auth::user()->id)
                            )
                        )
                            ->where('date', $record->date)
                            ->orderBy('green_coin', 'desc')
                            ->get();
                    }

                    if (Auth::user()->hasRole(['Coordenador'])) {
                        $swaps = Swap::whereHas(
                            relation: 'student',
                            callback: fn (Builder $query) => $query->whereHas(
                                relation: 'school',
                                callback: fn (Builder $query) => $query
                                    ->where('schools.coordinator_id', Auth::user()->id)
                            )
                        )
                            ->where('date', $record->date)
                            ->orderBy('green_coin', 'desc')
                            ->get();
                    }

                    return view('reports.swap.by-day', [
                        'params' => 'params',
                        'arguments' => $arguments,
                        'date' => $record->date,
                        'swaps' => $swaps
                    ]);
                })
                ->modalActions(null)
                ->modalFooter(null),

            Tables\Actions\ActionGroup::make([
                Tables\Actions\Action::make('Relatório')
                    ->icon('heroicon-o-document-download')
                    ->url(fn (Swap $record) => route('swapsByDate.pdf.download', $record->date))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('Pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-s-download')
                    ->action(function (Swap $record) {
                        return response()->streamDownload(function () use ($record) {
                            $swaps = null;

                            if (Auth::user()->hasRole(['Secretario'])) {
                                $swaps = Swap::whereHas(
                                    relation: 'student',
                                    callback: fn (Builder $query) => $query->whereHas(
                                        relation: 'school',
                                        callback: fn (Builder $query) => $query->whereHas(
                                            relation: 'city',
                                            callback: fn (Builder $query) => $query
                                                ->where('cities.secretary_id', Auth::user()->id)
                                        )
                                    )
                                )
                                    ->where('date', $record->date)
                                    ->orderBy('green_coin', 'desc')
                                    ->get();
                            }

                            if (Auth::user()->hasRole(['Gerente'])) {
                                $swaps = Swap::whereHas(
                                    relation: 'student',
                                    callback: fn (Builder $query) => $query->whereHas(
                                        relation: 'school',
                                        callback: fn (Builder $query) => $query
                                            ->where('schools.manager_id', Auth::user()->id)
                                    )
                                )
                                    ->where('date', $record->date)
                                    ->orderBy('green_coin', 'desc')
                                    ->get();
                            }

                            if (Auth::user()->hasRole(['Coordenador'])) {
                                $swaps = Swap::whereHas(
                                    relation: 'student',
                                    callback: fn (Builder $query) => $query->whereHas(
                                        relation: 'school',
                                        callback: fn (Builder $query) => $query
                                            ->where('schools.coordinator_id', Auth::user()->id)
                                    )
                                )
                                    ->where('date', $record->date)
                                    ->orderBy('green_coin', 'desc')
                                    ->get();
                            }

                            echo Pdf::loadHtml(
                                Blade::render('swap-by-day-pdf', [
                                    'date' => $record->date,
                                    'swaps' => $swaps
                                ])
                            )->stream();
                        }, 'trocas-dia-' . $record->date . '.pdf');
                    }),
            ]),
        ];
    }
}
