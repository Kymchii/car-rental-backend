<?php

namespace App\Filament\Resources\CarTypes\Pages;

use App\Filament\Resources\CarTypes\CarTypesResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCarTypes extends ViewRecord
{
    protected static string $resource = CarTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
