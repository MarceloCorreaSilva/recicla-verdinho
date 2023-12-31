<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers\SwapsRelationManager;
use App\Models\Student;
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
                    ->columns(1)
                    ->schema([
                        Forms\Components\Select::make('school_class_id')
                            ->label('Turma')
                            ->relationship('school_class', 'name')
                            ->preload()
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('name')
                            // ->columnStart(2)
                            ->columnSpanFull()
                            ->label('Nome Estudante')
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
                    ->searchable(),

                Tables\Columns\TextColumn::make('school_class.school.name')
                    ->label('Escola'),
                Tables\Columns\TextColumn::make('school_class.name')
                    ->label('Turma')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('Turma')
                    ->relationship('school_class', 'name')
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
            SwapsRelationManager::class
        ];
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
        return auth()->user()->hasRole(['Developer', 'Admin'])
            ? parent::getEloquentQuery()
            : parent::getEloquentQuery()->whereHas(
                relation: 'school_class',
                callback: function (Builder $query) {
                    if (isset(auth()->user()->coordinator->id)) {
                        return $query->where('school_id', auth()->user()->coordinator->id);
                    }

                    return null;
                }
            );
    }
}
