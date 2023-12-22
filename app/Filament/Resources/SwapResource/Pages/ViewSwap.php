<?php

namespace App\Filament\Resources\SwapResource\Pages;

use App\Filament\Resources\SwapResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSwap extends ViewRecord
{
    protected static string $resource = SwapResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['total'] = $data['pet_bottles'] + $data['packaging_of_cleaning_materials'] + $data['tetra_pak'] + $data['aluminum_cans'];

        return $data;
    }
}
