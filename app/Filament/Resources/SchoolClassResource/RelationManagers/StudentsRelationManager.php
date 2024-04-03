<?php

namespace App\Filament\Resources\SchoolClassResource\RelationManagers;

use App\Models\School;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';
    protected static ?string $title = 'Estudantes';

    protected static ?string $modelLabel = 'Estudante';
    protected static ?string $pluralModelLabel = 'Estudantes';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome Estudante')
                            ->columnSpan(2)
                            ->required(),

                        Forms\Components\TextInput::make('registration')
                            ->label('Matricula')
                            ->numeric()
                            ->required(),

                        Forms\Components\Select::make('gender')
                            ->label('Gênero')
                            ->options([
                                'M' => 'Masculino',
                                'F' => 'Feminino'
                            ])
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('registration')
                    ->label('Matricula'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (RelationManager $livewire, array $data): array {
                        $data['school_id'] = $livewire->ownerRecord->school_id;

                        return $data;
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
