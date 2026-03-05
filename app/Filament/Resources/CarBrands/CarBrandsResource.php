<?php

namespace App\Filament\Resources\CarBrands;

use App\Enums\Icons\GoogleMaterialDesignIcons;
use App\Filament\Resources\CarBrands\Pages\CreateCarBrands;
use App\Filament\Resources\CarBrands\Pages\EditCarBrands;
use App\Filament\Resources\CarBrands\Pages\ListCarBrands;
use App\Filament\Resources\CarBrands\Pages\ViewCarBrands;
use App\Filament\Resources\CarBrands\Schemas\CarBrandsForm;
use App\Filament\Resources\CarBrands\Schemas\CarBrandsInfolist;
use App\Filament\Resources\CarBrands\Tables\CarBrandsTable;
use App\Models\CarBrand;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CarBrandsResource extends Resource
{
    protected static ?string $model = CarBrand::class;
    protected static string|BackedEnum|null $navigationIcon = GoogleMaterialDesignIcons::LabelO;

    protected static ?string $recordTitleAttribute = 'Car Brands';

    public static function form(Schema $schema): Schema
    {
        return CarBrandsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CarBrandsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CarBrandsTable::configure($table);
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
            'index' => ListCarBrands::route('/'),
            'create' => CreateCarBrands::route('/create'),
            'view' => ViewCarBrands::route('/{record}'),
            'edit' => EditCarBrands::route('/{record}/edit'),
        ];
    }
}
