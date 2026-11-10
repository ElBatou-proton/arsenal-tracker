<?php

namespace App\Filament\Resources\WeaponAssignments\Pages;

use App\Filament\Resources\WeaponAssignments\WeaponAssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWeaponAssignments extends ListRecords
{
    protected static string $resource = WeaponAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
