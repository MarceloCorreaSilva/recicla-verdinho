<?php

namespace App\Filament\Resources\MovementResource\Pages;

use App\Filament\Resources\MovementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovement extends EditRecord
{
    protected static string $resource = MovementResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
