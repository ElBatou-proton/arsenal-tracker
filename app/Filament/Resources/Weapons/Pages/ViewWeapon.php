<?php

namespace App\Filament\Resources\Weapons\Pages;

use App\Filament\Resources\Weapons\WeaponResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWeapon extends ViewRecord
{
    protected static string $resource = WeaponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
