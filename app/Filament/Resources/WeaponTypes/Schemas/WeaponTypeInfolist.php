<?php

namespace App\Filament\Resources\WeaponTypes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WeaponTypeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('weapon_types.name')),
                TextEntry::make('description')
                    ->label(__('weapon_types.description'))
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('order')
                    ->label(__('weapon_types.order'))
                    ->numeric(),
                TextEntry::make('created_at')
                    ->label(__('weapon_types.created_at'))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label(__('weapon_types.updated_at'))
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
