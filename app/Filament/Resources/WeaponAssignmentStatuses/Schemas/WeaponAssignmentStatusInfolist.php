<?php

namespace App\Filament\Resources\WeaponAssignmentStatuses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WeaponAssignmentStatusInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('weapon_assignment_statuses.name')),
                TextEntry::make('description')
                    ->label(__('weapon_assignment_statuses.description'))
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label(__('weapon_assignment_statuses.created_at'))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label(__('weapon_assignment_statuses.updated_at'))
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
