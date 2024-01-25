<?php

namespace App\Filament\Resources\FinancialResource\RelationManagers;

use App\Enums\StatusType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';
    protected static ?string $title = 'Movimentação';

    protected static ?string $modelLabel = 'Movimentação';
    protected static ?string $pluralModelLabel = 'Movimentações';

    protected static ?string $recordTitleAttribute = 'financial_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // Forms\Components\TextInput::make('financial_id')
                //     ->required(),
                // Forms\Components\TextInput::make('student_id')
                //     ->required(),

                Forms\Components\Select::make('student_id')
                    ->label('Aluno')
                    ->relationship('student', 'name')
                    ->preload()
                    ->required()
                    ->searchable(),

                Forms\Components\DateTimePicker::make('date')
                    ->label('Data')
                    ->default(now())
                    ->displayFormat('d/m/Y H:i:s')
                    ->format('d/m/Y H:i:s')
                    ->dehydrateStateUsing(fn ($state) => date('Y-m-d H:i:s', strtotime($state)))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(),

                Forms\Components\TextInput::make('value')
                    ->label('Verdinhos')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('financial.school.name')->label('Escola'),
                Tables\Columns\TextColumn::make('student.name')->label('Aluno'),
                Tables\Columns\TextColumn::make('date')->dateTime('d/m/Y')->label('Data'),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        'output' => 'Saida',
                        'input' => 'Entrada'
                    ])
                    ->colors([
                        'danger' => 'output',
                        'success' => 'input',
                    ])
                    ->icon(static function ($state): string {
                        if ($state === 'output') {
                            return 'heroicon-o-arrow-circle-down';
                        }

                        return 'heroicon-o-arrow-circle-up';
                    })
                    ->icons([
                        'heroicon-o-arrow-circle-down' => 'output',
                        'heroicon-o-arrow-circle-up' => 'input'
                    ])
                    ->iconPosition('after'),
                Tables\Columns\TextColumn::make('value')->label('Verdinhos'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(StatusType::getKeyValues())
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true),
            ]);
    }
}
