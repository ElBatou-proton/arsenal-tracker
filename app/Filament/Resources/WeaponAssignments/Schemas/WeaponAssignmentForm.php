<?php

namespace App\Filament\Resources\WeaponAssignments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WeaponAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('weapon_id')
                    ->label(__('weapon_assignments.weapon_id'))
                    ->relationship('weapon', 'serial_number')
                    ->searchable()
                    ->required(),
                Select::make('owner_id')
                    ->label(__('weapon_assignments.owner_id'))
                    ->searchable()
                    ->nullable()
                    ->getSearchResultsUsing(function (string $search) {
                        return \App\Models\Owner::where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->select('id', 'first_name', 'last_name')
                            ->limit(50)
                            ->get()
                            ->map(function ($owner) {
                                return [
                                    'value' => $owner->id,
                                    'label' => "{$owner->first_name} {$owner->last_name}",
                                ];
                            });
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $owner = \App\Models\Owner::find($value);
                        return $owner ? "{$owner->first_name} {$owner->last_name}" : '';
                    }),
                TextInput::make('assigned_by')
                    ->label(__('weapon_assignments.assigned_by'))
                    ->required(),
                DateTimePicker::make('entry_date')
                    ->label(__('weapon_assignments.entry_date'))
                    ->required(),
                TextInput::make('reason')
                    ->label(__('weapon_assignments.reason'))
                    ->required(),
                Textarea::make('details')
                    ->label(__('weapon_assignments.details'))
                    ->columnSpanFull(),
                Select::make('status_id')
                    ->label(__('weapon_assignments.weapon_assignment_status_id'))
                    ->relationship('status', 'name')
                    ->default(1) // Default to 'active' status
                    ->required(),
                TextInput::make('destination')
                    ->label(__('weapon_assignments.destination')),
            ]);
    }
}
