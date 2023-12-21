<?php

namespace App\Filament\Resources\SwapResource\Pages;

use App\Filament\Resources\SwapResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSwap extends EditRecord
{
    protected static string $resource = SwapResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['green_coin'] = ($data['pet_bottles'] + $data['packaging_of_cleaning_materials'] + $data['tetra_pak'] + $data['aluminum_cans']) / 10;

        // dd($data);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
