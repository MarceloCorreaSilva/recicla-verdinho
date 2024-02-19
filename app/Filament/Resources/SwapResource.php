<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SwapResource\Pages;
use App\Filament\Resources\SwapResource\RelationManagers;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Swap;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class SwapResource extends Resource
{
    protected static ?string $model = Swap::class;
    protected static ?string $modelLabel = 'Troca';
    protected static ?string $pluralModelLabel = 'Trocas';

    protected static ?string $slug = 'trocas';

    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Escolas';
    protected static ?string $navigationIcon = 'heroicon-o-switch-horizontal';

    // protected static function shouldRegisterNavigation(): bool
    // {
    //     return auth()->user()->hasRole(['Developer', 'Admin']);
    // }

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::totalSwaps();
    // }



    public static function form(Form $form): Form
    {
        // $convertItens = $form;

        // dd($convertItens);

        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Data')
                            ->default(now())
                            ->displayFormat('d/m/Y')
                            ->format('d/m/Y')
                            ->dehydrateStateUsing(fn ($state) => date('Y-m-d', strtotime($state)))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(),

                        Forms\Components\Select::make('schools')
                            ->label('Escolas')
                            ->options(function () {
                                if (auth()->user()->coordinator) {
                                    return School::where('coordinator_id', '=', auth()->user()->coordinator->coordinator_id)->pluck('name', 'id')->toArray();
                                }

                                return School::all()->pluck('name', 'id')->toArray();
                            })
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $set('school_classes', '');
                            })
                            ->searchable()
                            ->reactive(),

                        Forms\Components\Select::make('school_classes')
                            ->label('Turmas')
                            ->options(function (Closure $get) {
                                $school = School::find($get('schools'));

                                if (!$school) {
                                    return []; // SchoolClass::all()->pluck('name', 'id');
                                }

                                return $school->school_classes->pluck('name', 'id');
                            })
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $set('student_id', '');
                            })
                            ->searchable()
                            ->reactive(),

                        Forms\Components\Select::make('student_id')
                            ->label('Aluno')
                            // ->relationship(
                            //     'student',
                            //     'name',
                            //     // fn (Builder $query) => $query->where('school_class_id', 21)
                            //     fn (Builder $query) => auth()->user()->coordinator
                            //         ?
                            //         $query
                            //         ->select('students.*')
                            //         ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                            //         ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                            //         ->where('school_id', auth()->user()->coordinator->id)
                            //         ->orderBy('school_classes.name')
                            //         :
                            //         $query->orderBy('students.name')
                            // )
                            ->options(function (Closure $get) {
                                $schoolClass = SchoolClass::find($get('school_classes'));

                                if (!$schoolClass) {
                                    return []; // Student::all()->pluck('name', 'id');
                                }

                                return $schoolClass->students()->orderBy('students.name')->pluck('name', 'id');
                            })
                            // ->preload()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $student = Student::all()->where('id', '=', $state)->first();
                                $financial = $student->school_class->school->financial;
                                // dd($financial);
                                $set('convert_itens', $financial["total_items"]);
                                $set('convert_green_coins', $financial["total_green_coins"]);
                            })
                            ->reactive(),
                    ]),

                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('pet_bottles')
                            ->label('Garrafas PET')
                            ->numeric()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $student = $get('student_id');
                                if ($student) {
                                    $convertItens = $get('convert_itens');
                                    $convertGreenCoins = $get('convert_green_coins');

                                    $pet = intval($get('pet_bottles')) ?? 0;
                                    $clear = intval($get('packaging_of_cleaning_materials')) ?? 0;
                                    $tetra_pak = intval($get('tetra_pak')) ?? 0;
                                    $aluminum_cans = intval($get('aluminum_cans')) ?? 0;

                                    $totalReciclaveis = $pet + $clear  + $tetra_pak + $aluminum_cans;
                                    $totalGreenCoins = floor(($totalReciclaveis) / $convertItens) * $convertGreenCoins;

                                    $set('green_coin', $totalGreenCoins);
                                    $set('total', $totalReciclaveis);
                                }
                            })
                            ->reactive(),
                        Forms\Components\TextInput::make('packaging_of_cleaning_materials')
                            ->label('Emb. Materiais de limpeza')
                            ->numeric()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $student = $get('student_id');
                                if ($student) {
                                    $convertItens = $get('convert_itens');
                                    $convertGreenCoins = $get('convert_green_coins');

                                    $pet = intval($get('pet_bottles')) ?? 0;
                                    $clear = intval($get('packaging_of_cleaning_materials')) ?? 0;
                                    $tetra_pak = intval($get('tetra_pak')) ?? 0;
                                    $aluminum_cans = intval($get('aluminum_cans')) ?? 0;

                                    $totalReciclaveis = $pet + $clear  + $tetra_pak + $aluminum_cans;
                                    $totalGreenCoins = floor(($totalReciclaveis) / $convertItens) * $convertGreenCoins;

                                    $set('green_coin', $totalGreenCoins);
                                    $set('total', $totalReciclaveis);
                                }
                            })
                            ->reactive(),
                        Forms\Components\TextInput::make('tetra_pak')
                            ->label('Tetra Pak')
                            ->numeric()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $student = $get('student_id');
                                if ($student) {
                                    $convertItens = $get('convert_itens');
                                    $convertGreenCoins = $get('convert_green_coins');

                                    $pet = intval($get('pet_bottles')) ?? 0;
                                    $clear = intval($get('packaging_of_cleaning_materials')) ?? 0;
                                    $tetra_pak = intval($get('tetra_pak')) ?? 0;
                                    $aluminum_cans = intval($get('aluminum_cans')) ?? 0;

                                    $totalReciclaveis = $pet + $clear  + $tetra_pak + $aluminum_cans;
                                    $totalGreenCoins = floor(($totalReciclaveis) / $convertItens) * $convertGreenCoins;

                                    $set('green_coin', $totalGreenCoins);
                                    $set('total', $totalReciclaveis);
                                }
                            })
                            ->reactive(),
                        Forms\Components\TextInput::make('aluminum_cans')
                            ->label('Latas de Alumínio')
                            ->numeric()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $student = $get('student_id');
                                if ($student) {
                                    $convertItens = $get('convert_itens');
                                    $convertGreenCoins = $get('convert_green_coins');

                                    $pet = intval($get('pet_bottles')) ?? 0;
                                    $clear = intval($get('packaging_of_cleaning_materials')) ?? 0;
                                    $tetra_pak = intval($get('tetra_pak')) ?? 0;
                                    $aluminum_cans = intval($get('aluminum_cans')) ?? 0;

                                    $totalReciclaveis = $pet + $clear  + $tetra_pak + $aluminum_cans;
                                    $totalGreenCoins = floor(($totalReciclaveis) / $convertItens) * $convertGreenCoins;

                                    $set('green_coin', $totalGreenCoins);
                                    $set('total', $totalReciclaveis);
                                }
                            })
                            ->reactive(),
                    ]),

                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->suffix(' /')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('convert_itens')
                            ->label('Conversão de Itens')
                            ->suffix(' *')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('convert_green_coins')
                            ->label('Conversão de Verdinhos')
                            ->suffix(' =')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('green_coin')
                            ->label('Verdinhos')
                            // ->required()
                            ->numeric()
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Aluno')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pet_bottles')
                    ->label('Garrafas PET')
                    ->sortable(),
                Tables\Columns\TextColumn::make('packaging_of_cleaning_materials')
                    ->label('Emb. Materiais de limpeza')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tetra_pak')
                    ->label('Tetra Pak')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aluminum_cans')
                    ->label('Latas de Alumínio')
                    ->sortable(),
                Tables\Columns\TextColumn::make('get_total_swaps')
                    ->label('Total'),
                Tables\Columns\TextColumn::make('green_coin')
                    ->label('Verdinhos')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('Turma')
                    ->relationship('student', 'name', function (Builder $query) {
                        if (isset(auth()->user()->coordinator->id)) {
                            return $query
                                ->select('school_classes.*')
                                ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                                ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                                ->where('school_id', auth()->user()->coordinator->id)
                                ->orderBy('school_classes.name');
                        }

                        return $query
                            ->select('school_classes.*')
                            ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                            ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                            ->orderBy('school_classes.name');
                    }),

                SelectFilter::make('Aluno')
                    // ->relationship('student', 'name')
                    ->relationship('student', 'name', function (Builder $query) {
                        if (isset(auth()->user()->coordinator->id)) {
                            return $query
                                ->select('students.*')
                                ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                                ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                                ->where('school_id', auth()->user()->coordinator->id)
                                ->orderBy('school_classes.name');
                        }

                        return null;
                    })
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSwaps::route('/'),
            'create' => Pages\CreateSwap::route('/create'),
            'view' => Pages\ViewSwap::route('/{record}'),
            'edit' => Pages\EditSwap::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->hasRole(['Developer', 'Admin'])
            ? parent::getEloquentQuery()
            : parent::getEloquentQuery()->whereHas(
                relation: 'student',
                callback: fn (Builder $query) => $query
                    ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                    ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                    ->where('school_id', auth()->user()->coordinator->id)
            );


        // ->relationship('student', 'name', function (Builder $query) {
        //     if (isset(auth()->user()->coordinator->id)) {
        //         return $query
        //             ->select('students.*')
        //             ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
        //             ->join('schools', 'schools.id', '=', 'school_classes.school_id')
        //             ->where('school_id', auth()->user()->coordinator->id)
        //             ->orderBy('school_classes.name');
        //     }

        //     return null;
        // })
    }
}
