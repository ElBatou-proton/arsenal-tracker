<?php

namespace App\Filament\Resources\WeaponTypes\Pages;

use App\Filament\Resources\WeaponTypes\WeaponTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWeaponType extends EditRecord
{
    protected static string $resource = WeaponTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
