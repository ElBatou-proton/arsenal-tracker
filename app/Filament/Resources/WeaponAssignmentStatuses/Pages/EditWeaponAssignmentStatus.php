<?php

namespace App\Filament\Resources\WeaponAssignmentStatuses\Pages;

use App\Filament\Resources\WeaponAssignmentStatuses\WeaponAssignmentStatusResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWeaponAssignmentStatus extends EditRecord
{
    protected static string $resource = WeaponAssignmentStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
