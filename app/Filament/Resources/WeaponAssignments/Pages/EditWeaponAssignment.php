<?php

namespace App\Filament\Resources\WeaponAssignments\Pages;

use App\Filament\Resources\WeaponAssignments\WeaponAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWeaponAssignment extends EditRecord
{
    protected static string $resource = WeaponAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
