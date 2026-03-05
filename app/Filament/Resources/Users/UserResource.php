<?php

namespace App\Filament\Resources\Users;

use App\Enums\Icons\GoogleMaterialDesignIcons;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Collection;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = GoogleMaterialDesignIcons::Group;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema)
        ->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->required()->email(),
            TextInput::make('password')->required()->password(),
            Select::make('role')->required()->options([
                'admin' => 'Admin',
                'client' => 'Client',
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->selectable()
        ->toolbarActions([
            BulkAction::make('delete')->requiresConfirmation()->action(fn (Collection $records) => $records->each->delete()),
        ])
        ->columns([
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email'),
            TextColumn::make('role'),
        ]);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
