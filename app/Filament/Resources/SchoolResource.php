<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolResource\Pages;
use App\Filament\Resources\SchoolResource\RelationManagers\SchoolClassesRelationManager;
use App\Models\City;
use App\Models\School;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;
    protected static ?string $modelLabel = 'Escola';
    protected static ?string $pluralModelLabel = 'Escolas';

    protected static ?string $slug = 'escolas';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Escolas';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Cidade' => $record->city->name,
            'Estado' => $record->city->state->name
        ];
    }

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
                        Forms\Components\Select::make('city_id')
                            ->label('Cidade')
                            ->options(City::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('name')
                            ->label('Escola')
                            ->required(),

                        Forms\Components\Toggle::make('active')
                            ->label('Ativo')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Gerente / Coordenador')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('manager')
                            ->label('Gerente')
                            ->relationship(
                                'manager',
                                'name',
                                fn (Builder $query): Builder => $query
                                    ->whereHas(
                                        'roles',
                                        callback: fn (Builder $query) => $query->where('name', 'Gerente')
                                    )
                            ),

                        Forms\Components\Select::make('coordinator')
                            ->label('Coordenador')
                            ->relationship(
                                'coordinator',
                                'name',
                                fn (Builder $query): Builder => $query
                                    ->whereHas(
                                        'roles',
                                        callback: fn (Builder $query) => $query->where('name', 'Coordenador')
                                    )
                            ),
                    ]),
                Forms\Components\Section::make('Limite Reciclaveis/Troca')
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('limit_per_swap')
                            ->label('Limite Reciclaveis/Troca')
                            ->required(),
                    ]),
                Forms\Components\Section::make('Período do Projeto')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('project_started')
                            ->label('Inicio')
                            ->displayFormat('d/m/Y')
                            ->format('d/m/Y')
                            ->icon('heroicon-o-calendar')
                            ->dehydrateStateUsing(fn ($state) => date('Y-m-d', strtotime($state)))
                            ->dehydrated(fn ($state) => filled($state)),

                        Forms\Components\DatePicker::make('project_completed')
                            ->label('Conclusão')
                            ->displayFormat('d/m/Y')
                            ->format('d/m/Y')
                            ->icon('heroicon-o-calendar')
                            ->dehydrateStateUsing(fn ($state) => date('Y-m-d', strtotime($state)))
                            ->dehydrated(fn ($state) => filled($state)),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('city.name')
                //     ->label('Cidade')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->description(fn (School $record): string => 'Municipio: ' . $record->city->name)
                    ->label('Escola')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('manager.name')
                    // ->boolean()
                    ->label('Gerente'),

                Tables\Columns\TextColumn::make('coordinator.name')
                    // ->boolean()
                    ->label('Coordenador'),

                Tables\Columns\TextColumn::make('school_classes_count')
                    ->counts('school_classes')
                    ->label('Nº Turmas'),

                Tables\Columns\TextColumn::make('students_count')
                    ->counts('students')
                    ->label('Nº Aluno'),

                Tables\Columns\TextColumn::make('limit_per_swap')
                    ->label('Limite Reciclaveis/Troca'),

                Tables\Columns\TextColumn::make('project_started')
                    ->label('Inicio do Projeto ')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_completed')
                    ->label('Conclusão do Projeto')
                    ->dateTime('d/m/Y')
                    ->sortable(),

                // Tables\Columns\ToggleColumn::make('active')
                //     ->label('Status')
                //     ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label('Status')
                // ->visible(auth()->user()->hasRole(['Coordenador']) == true)
            ])
            ->filters([
                SelectFilter::make('Cidade')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true),
            ])
            ->actions([
                // Tables\Actions\ActionGroup::make([]),
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
            SchoolClassesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'view' => Pages\ViewSchool::route('/{record}'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(['Developer', 'Admin'])) {
            return parent::getEloquentQuery();
        } else if (auth()->user()->hasRole(['Secretario'])) {
            return parent::getEloquentQuery()->whereHas(
                relation: 'city',
                callback: fn (Builder $query) => $query
                    ->where('cities.secretary_id', auth()->user()->id)
            );
        } else if (auth()->user()->hasRole(['Gerente'])) {
            return parent::getEloquentQuery()->where('manager_id', auth()->user()->id);
        } else if (auth()->user()->hasRole(['Coordenador'])) {
            return parent::getEloquentQuery()->where('coordinator_id', auth()->user()->id);
        }

        return parent::getEloquentQuery();
    }
}
