<?php

namespace App\Filament\Resources\WeaponAssignmentStatuses\Pages;

use App\Filament\Resources\WeaponAssignmentStatuses\WeaponAssignmentStatusResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWeaponAssignmentStatus extends ViewRecord
{
    protected static string $resource = WeaponAssignmentStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
