<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers\SwapsRelationManager;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function PHPUnit\Framework\isNull;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $modelLabel = 'Estudante';
    protected static ?string $pluralModelLabel = 'Estudantes';

    protected static ?string $slug = 'estudantes';

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Escolas';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Escola' => $record->school_class->school->name,
            'Turma' => $record->school_class->name,
        ];
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\Select::make('school_id')
                            ->label('Escola')
                            ->relationship('school', 'name')
                            ->preload()
                            ->required()
                            ->searchable()
                            ->columnSpan(3),

                        Forms\Components\Select::make('school_class_id')
                            ->label('Turma')
                            // ->relationship('school_class', 'name')
                            ->options(function (Closure $get) {
                                $school = School::find($get('school_id'));
                                return $school ? $school->school_classes->pluck('name', 'id') : [];
                            })
                            ->preload()
                            ->required()
                            ->searchable(),

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
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome Estudante')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('swaps_count')->counts('swaps')->label('Nº de Trocas'),
                Tables\Columns\TextColumn::make('itens_count')->label('Nº de Itens'),
                Tables\Columns\TextColumn::make('greencoins_count')->label('Nº de Verdinhos'),

                Tables\Columns\TextColumn::make('school_class.school.name')
                    ->label('Escola'),
                Tables\Columns\TextColumn::make('school_class.name')
                    ->label('Turma')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('Turma')
                    ->relationship('school_class', 'name', function (Builder $query) {
                        if (isset(auth()->user()->coordinator->id)) {
                            return $query->where('school_id', auth()->user()->coordinator->id);
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
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin']) == true),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SwapsRelationManager::class
        ];

        // $level = 1;
        // $id = null;
        // $lbl = 'Level 1';
        // return [
        //     app(QuestionsRelationManager::class, [
        //         'id' => $id,
        //         'level' => $level,
        //         'lbl' => $lbl,
        //     ]),
        // ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(['Developer', 'Admin'])) {
            return parent::getEloquentQuery();
        } else if (auth()->user()->hasRole(['Secretario'])) {
            return parent::getEloquentQuery()->whereHas(
                relation: 'school_class',
                callback: fn (Builder $query) => $query
                    ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                    ->join('cities', 'cities.id', '=', 'schools.city_id')
                    ->where('cities.secretary_id', auth()->user()->id)
            );
        } else if (auth()->user()->hasRole(['Gerente'])) {
            return parent::getEloquentQuery()->whereHas(
                relation: 'school_class',
                callback: fn (Builder $query) => $query
                    ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                    ->where('schools.manager_id', auth()->user()->id)
            );
        } else if (auth()->user()->hasRole(['Coordenador'])) {
            return parent::getEloquentQuery()->whereHas(
                relation: 'school_class',
                callback: fn (Builder $query) => $query
                    ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                    ->where('schools.coordinator_id', auth()->user()->id)
            );
        }

        return parent::getEloquentQuery();
    }
}
