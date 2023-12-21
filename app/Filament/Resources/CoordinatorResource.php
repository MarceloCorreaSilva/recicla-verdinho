<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoordinatorResource\Pages;
use App\Filament\Resources\CoordinatorResource\RelationManagers;
use App\Models\Coordinator;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class CoordinatorResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Coordenador';
    protected static ?string $pluralModelLabel = 'Coordenadores';

    protected static ?string $slug = 'coordenadores';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Escolas';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereHas(
            'roles',
            callback: fn (Builder $query) => $query->where('name', 'Coordinator')
        )->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome Coordenador')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Senha')
                    ->default('verdinho')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),

                Forms\Components\Select::make('roles')
                    ->label('Função')
                    ->multiple()
                    ->relationship('roles', 'name', fn (Builder $query) =>  auth()->user()->hasRole('Developer') ? null : $query->where('name', '=', 'Coordinator'))
                    ->preload(),

                // Forms\Components\Select::make('role_id')
                //     ->label('Função')
                //     // ->default(3)
                //     ->options(Role::all()->pluck('name', 'id'))
                //     ->required()
                //     ->searchable(),

                // Forms\Components\Select::make('roles')
                // ->label('Função')
                // // ->default(3)
                // ->relationship(
                //     'roles',
                //     'name',
                // ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Função')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome Coordenador')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Criação')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('roles.name')
                    ->query(
                        fn (Builder $query): Builder => $query
                            ->whereHas(
                                'roles',
                                callback: fn (Builder $query) => $query->where('name', 'Coordinator')
                            )
                    )
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
            'index' => Pages\ListCoordinators::route('/'),
            'create' => Pages\CreateCoordinator::route('/create'),
            'edit' => Pages\EditCoordinator::route('/{record}/edit'),
        ];
    }
}
