<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\CarType;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->required(),
                Select::make('user_id')
                    ->label('User')
                    ->required()
                    ->searchable()
                    ->options(User::query()->pluck('name', 'id')),
                Select::make('car_type_id')
                    ->label('Car')
                    ->required()
                    ->searchable()
                    ->options(CarType::query()->pluck('name', 'id')),
                DatePicker::make('start_at')
                    ->required(),
                DatePicker::make('end_of')
                    ->required(),
                Toggle::make('payment')
                    ->required(),
            ]);
    }
}
