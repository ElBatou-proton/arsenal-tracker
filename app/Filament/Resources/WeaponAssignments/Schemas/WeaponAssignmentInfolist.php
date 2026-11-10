<?php

namespace App\Filament\Resources\WeaponAssignments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WeaponAssignmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('weapon.serial_number')
                    ->label(__('weapon_assignments.table_columns.weapon_id')),
                TextEntry::make('owner.first_name')
                    ->label(__('weapon_assignments.table_columns.owner_id'))
                    ->formatStateUsing(fn ($record) => $record->owner ? "{$record->owner->first_name} {$record->owner->last_name}" : '-')
                    ->placeholder('-'),
                TextEntry::make('assigned_by')
                    ->label(__('weapon_assignments.table_columns.assigned_by')),
                TextEntry::make('entry_date')
                    ->label(__('weapon_assignments.table_columns.entry_date'))
                    ->dateTime(),
                TextEntry::make('reason')
                    ->label(__('weapon_assignments.table_columns.reason')),
                TextEntry::make('details')
                    ->label(__('weapon_assignments.table_columns.details'))
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status.name')
                    ->label(__('weapon_assignments.table_columns.weapon_assignment_status_id'))
                    ->badge()
                    ->color(fn ($record) => $record->status?->color ?? 'gray'),
                TextEntry::make('destination')
                    ->label(__('weapon_assignments.table_columns.destination'))
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label(__('weapon_assignments.table_columns.created_at'))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label(__('weapon_assignments.table_columns.updated_at'))
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
