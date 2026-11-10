<?php

namespace App\Filament\Resources\WeaponAssignmentStatuses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WeaponAssignmentStatusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('weapon_assignment_statuses.name'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('weapon_assignment_statuses.description'))
                    ->columnSpanFull(),
            ]);
    }
}
