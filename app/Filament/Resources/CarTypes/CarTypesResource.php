<?php

namespace App\Filament\Resources\CarTypes;

use App\Enums\Icons\GoogleMaterialDesignIcons;
use App\Filament\Resources\CarTypes\Pages\CreateCarTypes;
use App\Filament\Resources\CarTypes\Pages\EditCarTypes;
use App\Filament\Resources\CarTypes\Pages\ListCarTypes;
use App\Filament\Resources\CarTypes\Pages\ViewCarTypes;
use App\Filament\Resources\CarTypes\Schemas\CarTypesForm;
use App\Filament\Resources\CarTypes\Schemas\CarTypesInfolist;
use App\Filament\Resources\CarTypes\Tables\CarTypesTable;
use App\Models\CarType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CarTypesResource extends Resource
{
    protected static ?string $model = CarType::class;

    protected static string|BackedEnum|null $navigationIcon = GoogleMaterialDesignIcons::CarRental;

    protected static ?string $recordTitleAttribute = 'Car Models';

    public static function form(Schema $schema): Schema
    {
        return CarTypesForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CarTypesInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CarTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCarTypes::route('/'),
            'create' => CreateCarTypes::route('/create'),
            'view' => ViewCarTypes::route('/{record}'),
            'edit' => EditCarTypes::route('/{record}/edit'),
        ];
    }
}
