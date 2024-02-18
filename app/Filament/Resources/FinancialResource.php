<?php

namespace App\Filament\Resources;

use App\Enums\StatusType;
use App\Filament\Resources\FinancialResource\Pages;
use App\Filament\Resources\FinancialResource\RelationManagers;
use App\Filament\Resources\FinancialResource\RelationManagers\MovementsRelationManager;
use App\Models\Financial;
use App\Models\Movement;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinancialResource extends Resource
{
    protected static ?string $model = Financial::class;
    protected static ?string $modelLabel = 'Financeiro';
    protected static ?string $pluralModelLabel = 'Financeiro';

    protected static ?string $slug = 'financeiro';

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole(['Developer', 'Admin'])
            ? true
            : (isset(auth()->user()->coordinator) ? true : false);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->label('Escola')
                    ->relationship('school', 'name')
                    ->preload()
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('balance')
                    ->label('Saldo'),

                Forms\Components\TextInput::make('total_items')
                    ->label('Conversão - Itens'),
                Forms\Components\TextInput::make('total_green_coins')
                    ->label('Conversão - Verdinhos'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->label('Escola')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->label('Saldo'),
                Tables\Columns\TextColumn::make('total_items')
                    ->label('Conversão - Itens'),
                Tables\Columns\TextColumn::make('total_green_coins')
                    ->label('Conversão - Verdinhos'),


                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('saldo')
                    ->icon('heroicon-o-cash')
                    ->form([
                        Forms\Components\TextInput::make('balance')
                            ->label('Saldo')
                            ->required()
                            ->minValue(1)
                            ->maxValue(2000)
                    ])
                    ->action(function (array $data, Financial $record): void {
                        Movement::create([
                            'financial_id' => $record->id,
                            'student_id' => 0,
                            'date' => now(),
                            'status' => 'input',
                            'value' => $data['balance']
                        ]);

                        $record->balance = ($record->balance + $data['balance']);
                        $record->save();
                    })
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true)

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true)
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MovementsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancials::route('/'),
            'create' => Pages\CreateFinancial::route('/create'),
            'view' => Pages\ViewFinancial::route('/{record}'),
            'edit' => Pages\EditFinancial::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->hasRole(['Developer', 'Admin'])
            ? parent::getEloquentQuery()
            : parent::getEloquentQuery()->whereHas(
                relation: 'school',
                callback: function (Builder $query) {
                    if (isset(auth()->user()->coordinator->id)) {
                        return $query->where('school_id', '=', auth()->user()->coordinator->id);
                    } else if (auth()->user()->coordinator->id === null) {
                        return [];
                    }

                    return [];
                }
            );
    }
}
