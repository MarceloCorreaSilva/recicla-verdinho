<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers\UsersRelationManager;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CityResource extends Resource
{
    protected static ?string $model = City::class;
    protected static ?string $modelLabel = 'Cidade';
    protected static ?string $pluralModelLabel = 'Cidades';

    protected static ?string $slug = 'cidades';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Estados / Cidades';
    protected static ?string $navigationIcon = 'heroicon-o-location-marker';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Estado' => $record->state->name
        ];
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::where('active', true)->count();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('state_id')
                    ->label('Estados')
                    ->options(State::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('name')
                    ->label('Cidade')
                    ->required(),

                // Forms\Components\Section::make('Secretario(a)')
                //     ->columns(1)
                //     ->schema([
                //         Forms\Components\Select::make('secretary')
                //             ->label('Secretario(a)')
                //             ->relationship(
                //                 'secretary',
                //                 'name',
                //                 // fn (City $record, Builder $query): Builder => $query
                //                 //     ->whereHas(
                //                 //         'roles',
                //                 //         callback: fn (Builder $query) => $query->where('city_id', $record->id)->where('name', 'Secretario')
                //                 //     )
                //             ),
                //     ]),

                Forms\Components\Toggle::make('active')
                    ->label('Ativo')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('state.name')
                    ->label('Estado')
                    // ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Cidade')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('secretary.name')
                    // ->boolean()
                    ->label('Secretario(0)'),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Ativo')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Secretario(a)')
                    ->icon('heroicon-o-user')
                    ->form([
                        Forms\Components\Select::make('secretary')
                            ->label('Secretario(a)')
                            ->relationship(
                                'secretary',
                                'name',
                                fn (City $record, Builder $query): Builder => $query
                                    ->whereHas(
                                        'roles',
                                        callback: fn (Builder $query) => $query->where('city_id', $record->id)->where('name', 'Secretario')
                                    )
                            ),
                    ])
                    ->action(function (array $data, City $record): void {
                        $record->secretary_id = $data['secretary'];
                        $record->save();
                    })
                    ->visible(auth()->user()->hasRole(['Developer', 'Admin', 'Secretario']) == true),

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
            UsersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'view' => Pages\ViewCity::route('/{record}'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
