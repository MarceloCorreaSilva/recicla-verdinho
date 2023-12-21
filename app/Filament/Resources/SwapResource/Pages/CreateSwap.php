<?php

namespace App\Filament\Resources\SwapResource\Pages;

use App\Filament\Resources\SwapResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSwap extends CreateRecord
{
    protected static string $resource = SwapResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['green_coin'] = ($data['pet_bottles'] + $data['packaging_of_cleaning_materials'] + $data['tetra_pak'] + $data['aluminum_cans']) / 10;

        // dd($data);
        return $data;
    }
}
