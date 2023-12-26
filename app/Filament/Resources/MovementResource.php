<?php

namespace App\Filament\Resources;

use App\Enums\StatusType;
use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Models\Movement;
use App\Models\School;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;
    protected static ?string $modelLabel = 'Movimento';
    protected static ?string $pluralModelLabel = 'Movimento';

    protected static ?string $slug = 'movimento';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Financeiro';
    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole(['Developer', 'Admin']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('financial_id')
                    ->label('Escola')
                    ->relationship('financial', 'school_id')
                    // ->getOptionLabelUsing(fn ($value): ?string => School::find($value)?->name)
                    // ->relationship('financial', 'financial.school.name as name', fn (Builder $query) => $query->orderBy('financial.school.name'))
                    ->preload()
                    ->required(),

                // Forms\Components\Select::make('author_id')
                //     ->searchable()
                //     ->preload()
                //     ->getSearchResultsUsing(fn (string $search): array => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                //     ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name),

                // Forms\Components\TextInput::make('student_id')
                //     ->label('Aluno')
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
                Tables\Columns\TextColumn::make('financial.school.name')
                    ->label('Escola'),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Aluno'),
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i:s'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Operação')
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
                Tables\Columns\TextColumn::make('value')
                    ->label('Verdinhos'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(StatusType::getKeyValues())
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMovements::route('/'),
            'create' => Pages\CreateMovement::route('/create'),
            'edit' => Pages\EditMovement::route('/{record}/edit'),
        ];
    }
}
