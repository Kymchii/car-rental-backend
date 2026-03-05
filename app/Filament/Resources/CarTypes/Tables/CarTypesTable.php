<?php

namespace App\Filament\Resources\CarTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CarTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Model')
                    ->searchable(true)
                    ->sortable(true),
                TextColumn::make('registration_number')
                    ->label('Plat')
                    ->searchable(true),
                IconColumn::make('is_available')
                    ->label('Available')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('price')
                    ->sortable()
                    ->money('IDR', 1),
                TextColumn::make('color')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                ImageColumn::make('photo'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
