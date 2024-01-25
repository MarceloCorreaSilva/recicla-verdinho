<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolClassResource\Pages;
use App\Filament\Resources\SchoolClassResource\RelationManagers;
use App\Filament\Resources\SchoolClassResource\RelationManagers\StudentsRelationManager;
use App\Filament\Resources\SchoolResource\RelationManagers\SchoolClassesRelationManager;
use App\Models\School;
use App\Models\SchoolClass;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolClassResource extends Resource
{
    protected static ?string $model = SchoolClass::class;
    protected static ?string $modelLabel = 'Turma';
    protected static ?string $pluralModelLabel = 'Turmas';

    protected static ?string $slug = 'turmas';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Escolas';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::where('active', true)->count() . '/' . static::getModel()::count();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        // Forms\Components\TextInput::make('school.name')
                        //     ->label('Escolas')
                        //     ->hydrateState(fn (Builder $query) => $query->where('coordinator_id', auth()->id())->first()->name),

                        Forms\Components\Select::make('school_id')
                            ->label('Escolas')
                            ->relationship('school', 'name', fn (Builder $query) => $query->where('coordinator_id', auth()->id()))
                            ->preload()
                            ->required()
                            ->searchable(),
                    ]),

                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('year')
                            ->label('Ano Letivo')
                            ->required()
                            ->numeric()
                            // ->mask('9999')
                            ->length(4),

                        Forms\Components\TextInput::make('name')
                            // ->columnStart(2)
                            // ->columnSpanFull()
                            ->label('Turma')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\Toggle::make('active')
                            ->label('Ativo')
                            ->columnSpanFull()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->label('Escola')
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Ano Letivo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Turma')
                    ->searchable(),
                Tables\Columns\TextColumn::make('students_count')
                    ->counts('students')
                    ->label('Nº Alunos'),
                // Tables\Columns\ToggleColumn::make('active')
                //     ->label('Status'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label('Status')
            ])
            ->filters([
                SelectFilter::make('Escola')
                    ->relationship('school', 'name')
                    ->searchable()
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchoolClasses::route('/'),
            'create' => Pages\CreateSchoolClass::route('/create'),
            'view' => Pages\ViewSchoolClass::route('/{record}'),
            'edit' => Pages\EditSchoolClass::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->hasRole(['Developer', 'Admin'])
            ? parent::getEloquentQuery()
            : parent::getEloquentQuery()->whereHas(
                relation: 'school',
                callback: fn (Builder $query) => $query->where('coordinator_id', auth()->id())
            );
    }
}
