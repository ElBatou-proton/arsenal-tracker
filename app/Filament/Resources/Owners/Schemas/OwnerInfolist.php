<?php

namespace App\Filament\Resources\Owners\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OwnerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('first_name')
                    ->label(__('owners.first_name')),
                TextEntry::make('last_name')
                    ->label(__('owners.last_name')),
                TextEntry::make('email')
                    ->label(__('owners.email')),
                TextEntry::make('phone')
                    ->label(__('owners.phone'))
                    ->placeholder('-'),
                TextEntry::make('rank.name')
                    ->label(__('owners.rank'))
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label(__('owners.created_at'))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label(__('owners.updated_at'))
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
