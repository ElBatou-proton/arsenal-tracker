<?php

namespace App\Filament\Resources\WeaponAssignments\Pages;

use App\Filament\Resources\WeaponAssignments\WeaponAssignmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWeaponAssignment extends ViewRecord
{
    protected static string $resource = WeaponAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
