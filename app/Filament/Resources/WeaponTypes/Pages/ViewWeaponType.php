<?php

namespace App\Filament\Resources\WeaponTypes\Pages;

use App\Filament\Resources\WeaponTypes\WeaponTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWeaponType extends ViewRecord
{
    protected static string $resource = WeaponTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
