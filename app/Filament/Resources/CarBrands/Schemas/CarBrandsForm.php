<?php

namespace App\Filament\Resources\CarBrands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CarBrandsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('logo')
                    ->image()
                    ->imageEditor()
                    ->directory('car-brands')
                    ->visibility('public')
                    ->disk('imagekit')
            ]);
    }
}