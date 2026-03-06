<?php

namespace App\Filament\Resources\CarTypes\Schemas;

use App\Models\CarBrand;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CarTypesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('brand_id')->required()->options(CarBrand::query()->pluck('name', 'id'))->searchable(),
                TextInput::make('name')->required()->maxLength(255),
                Select::make('is_available')->required()->options([
                    true => 'Tersedia',
                    false => 'Tidak tersedia'
                ]),
                TextInput::make('price')->required()->numeric(),
                Select::make('type')->required()->options([
                    'sedan' => 'Sedan',
                    'suv' => 'SUV',
                    'mpv' => 'MPV',
                ]),
                TextInput::make('color')->required(),
                FileUpload::make('photo')->image()->imageEditor()->directory('car-models')->visibility('public')->disk('imagekit'),
            ]);
    }
}