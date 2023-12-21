<?php

namespace App\Filament\Resources\CoordinatorResource\Pages;

use App\Filament\Resources\CoordinatorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoordinators extends ListRecords
{
    protected static string $resource = CoordinatorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
