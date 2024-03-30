<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\City;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';

    protected static ?string $slug = 'usuarios';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::whereHas(
    //         relation: 'roles',
    //         callback: fn (Builder $query) => $query->where('name', '<>', 'Developer')
    //     )->count();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome Usuário')
                    ->required()
                    ->columnSpan(3),

                Forms\Components\Select::make('city_id')
                    ->label('Cidade')
                    ->relationship('city', 'id')
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (City $record) => "{$record->name} - {$record->state->abbreviation}"),


                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->columnSpan(2),
                Forms\Components\TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->columnSpan(1),

                Forms\Components\Select::make('roles')
                    ->label('Função')
                    ->multiple()
                    ->relationship('roles', 'name', fn (Builder $query) =>  auth()->user()->hasRole('Developer') ? null : $query->where('name', '<>', 'Developer'))
                    ->preload()
                    ->columnSpan(1),
            ])
            ->columns(4);
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
                    ->label('Nome Usuário')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Criação')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->hasRole('Developer')
            ? parent::getEloquentQuery()
            : parent::getEloquentQuery()->whereHas(
                relation: 'roles',
                callback: fn (Builder $query) => $query->where('name', '<>', 'Developer')
            );
    }
}
