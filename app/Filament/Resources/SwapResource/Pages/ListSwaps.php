<?php

namespace App\Filament\Resources\SwapResource\Pages;

use App\Filament\Resources\SwapResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSwaps extends ListRecords
{
    protected static string $resource = SwapResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
