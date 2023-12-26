<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Filament\Resources\SwapResource;
use App\Models\Financial;
use App\Models\Movement;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use Closure;
use Str;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SwapsRelationManager extends RelationManager
{
    protected static string $relationship = 'swaps';
    protected static ?string $title = 'Trocas';

    protected static ?string $modelLabel = 'Troca';
    protected static ?string $pluralModelLabel = 'Trocas';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Data')
                            ->default(now())
                            ->displayFormat('d/m/Y')
                            ->format('d/m/Y')
                            ->dehydrateStateUsing(fn ($state) => date('Y-m-d', strtotime($state)))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required()
                    ]),

                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('pet_bottles')
                            ->label('Garrafas PET')
                            ->numeric()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $set('green_coin', floor(($get('pet_bottles') + $get('packaging_of_cleaning_materials') + $get('tetra_pak') + $get('aluminum_cans')) / 10));
                                $set('total', $get('pet_bottles') + $get('packaging_of_cleaning_materials') + $get('tetra_pak') + $get('aluminum_cans')) / 10;
                            })
                            ->reactive(),
                        Forms\Components\TextInput::make('packaging_of_cleaning_materials')
                            ->label('Emb. Materiais de limpeza')
                            ->numeric()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $set('green_coin', floor(($get('pet_bottles') + $get('packaging_of_cleaning_materials') + $get('tetra_pak') + $get('aluminum_cans')) / 10));
                                $set('total', $get('pet_bottles') + $get('packaging_of_cleaning_materials') + $get('tetra_pak') + $get('aluminum_cans')) / 10;
                            })
                            ->reactive(),
                        Forms\Components\TextInput::make('tetra_pak')
                            ->label('Tetra Pak')
                            ->numeric()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $set('green_coin', floor(($get('pet_bottles') + $get('packaging_of_cleaning_materials') + $get('tetra_pak') + $get('aluminum_cans')) / 10));
                                $set('total', $get('pet_bottles') + $get('packaging_of_cleaning_materials') + $get('tetra_pak') + $get('aluminum_cans')) / 10;
                            })
                            ->reactive(),
                        Forms\Components\TextInput::make('aluminum_cans')
                            ->label('Latas de Alumínio')
                            ->numeric()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                $set('green_coin', floor(($get('pet_bottles') + $get('packaging_of_cleaning_materials') + $get('tetra_pak') + $get('aluminum_cans')) / 10));
                                $set('total', $get('pet_bottles') + $get('packaging_of_cleaning_materials') + $get('tetra_pak') + $get('aluminum_cans')) / 10;
                            })
                            ->reactive(),
                    ]),

                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->suffix(' / 10')
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
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    // ->beforeFormValidated(function (Model $record, array $data) {
                    //     dd($data);
                    // })
                    ->after(function (Model $record, array $data) {
                        // Runs after the form fields are saved to the database.

                        $student = Student::all()->where('id', $record->student_id)->first();
                        $schoolClass = SchoolClass::all()->where('id', $student->school_class_id)->first();
                        $school = School::all()->where('id', $schoolClass->school_id)->first();

                        $financial = Financial::all()->where('school_id', $school->id)->first();

                        $movement = Movement::create([
                            'financial_id' => $financial->id,
                            'student_id' => $student->id,
                            'date' => now(),
                            'status' => 'output',
                            'value' => $record->green_coin
                        ]);

                        $financial->balance = ($financial->balance - $movement->value);
                        $financial->save();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
