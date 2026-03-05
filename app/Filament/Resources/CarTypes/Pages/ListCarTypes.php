<?php

namespace App\Filament\Resources\CarTypes\Pages;

use App\Filament\Resources\CarTypes\CarTypesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCarTypes extends ListRecords
{
    protected static string $resource = CarTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
