<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SwapResource\Pages;
use App\Filament\Resources\SwapResource\RelationManagers;
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

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole(['Developer', 'Admin']);
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::totalSwaps();
    // }

    public static function form(Form $form): Form
    {
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

                        Forms\Components\Select::make('student_id')
                            ->label('Aluno')
                            ->relationship(
                                'student',
                                'name',
                                // fn (Builder $query) => $query->where('school_class_id', 21)
                            )
                            ->preload()
                            ->required()
                            ->searchable()
                            ->columnSpanFull(),
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
                SelectFilter::make('Aluno')
                    ->relationship('student', 'name')
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
}
