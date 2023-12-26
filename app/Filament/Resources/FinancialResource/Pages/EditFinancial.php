<?php

namespace App\Filament\Resources\FinancialResource\Pages;

use App\Filament\Resources\FinancialResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinancial extends EditRecord
{
    protected static string $resource = FinancialResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
