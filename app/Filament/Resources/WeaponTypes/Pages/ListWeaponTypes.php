<?php

namespace App\Filament\Resources\WeaponTypes\Pages;

use App\Filament\Resources\WeaponTypes\WeaponTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWeaponTypes extends ListRecords
{
    protected static string $resource = WeaponTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
