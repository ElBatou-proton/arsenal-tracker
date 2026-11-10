<?php

namespace App\Filament\Resources\Ranks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RankInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('ranks.name')),
                TextEntry::make('abbreviation')
                    ->label(__('ranks.abbreviation')),
                TextEntry::make('order')
                    ->label(__('ranks.order'))
                    ->numeric(),
                TextEntry::make('description')
                    ->label(__('ranks.description'))
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label(__('ranks.created_at'))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label(__('ranks.updated_at'))
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
