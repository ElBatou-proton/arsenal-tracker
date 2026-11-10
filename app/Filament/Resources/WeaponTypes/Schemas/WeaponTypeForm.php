<?php

namespace App\Filament\Resources\WeaponTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WeaponTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('weapon_types.name'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('weapon_types.description'))
                    ->columnSpanFull(),
                TextInput::make('order')
                    ->label(__('weapon_types.order'))
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
