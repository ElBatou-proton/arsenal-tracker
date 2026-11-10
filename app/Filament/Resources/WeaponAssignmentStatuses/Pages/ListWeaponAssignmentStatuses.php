<?php

namespace App\Filament\Resources\WeaponAssignmentStatuses\Pages;

use App\Filament\Resources\WeaponAssignmentStatuses\WeaponAssignmentStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWeaponAssignmentStatuses extends ListRecords
{
    protected static string $resource = WeaponAssignmentStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
