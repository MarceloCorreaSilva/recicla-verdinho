<?php

namespace App\Filament\Resources\SchoolResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolClassesRelationManager extends RelationManager
{
    protected static string $relationship = 'school_classes';
    protected static ?string $title = 'Turmas';

    protected static ?string $modelLabel = 'Turma';
    protected static ?string $pluralModelLabel = 'Turmas';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('year')
                            ->label('Ano Letivo')
                            ->required()
                            ->numeric()
                            // ->mask('9999')
                            ->length(4),

                        Forms\Components\TextInput::make('name')
                            // ->columnStart(2)
                            ->columnSpanFull()
                            ->label('Turma')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Toggle::make('active')
                    ->label('Ativo')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('year')->label('Ano Letivo'),
                Tables\Columns\TextColumn::make('name')->label('Turma'),
                Tables\Columns\ToggleColumn::make('active')->label('Status')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\CreateAction::make(),
                Tables\Actions\DeleteAction::make(),
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
