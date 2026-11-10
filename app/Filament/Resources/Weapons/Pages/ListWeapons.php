<?php

namespace App\Filament\Resources\Weapons\Pages;

use App\Filament\Resources\Weapons\WeaponResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWeapons extends ListRecords
{
    protected static string $resource = WeaponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
