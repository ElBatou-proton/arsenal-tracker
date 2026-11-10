<?php

namespace App\Filament\Resources\Weapons;

use App\Filament\Resources\Weapons\Pages\CreateWeapon;
use App\Filament\Resources\Weapons\Pages\EditWeapon;
use App\Filament\Resources\Weapons\Pages\ListWeapons;
use App\Filament\Resources\Weapons\Pages\ViewWeapon;
use App\Filament\Resources\Weapons\Schemas\WeaponForm;
use App\Filament\Resources\Weapons\Schemas\WeaponInfolist;
use App\Filament\Resources\Weapons\Tables\WeaponsTable;
use App\Models\Weapon;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WeaponResource extends Resource
{
    protected static ?string $model = Weapon::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('weapons.resource_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('weapons.resource_label_plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('weapons.resource_label_plural');
    }

    public static function getNavigationGroup(): string
    {
        return __('weapons.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return WeaponForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WeaponInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeaponsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWeapons::route('/'),
            'create' => CreateWeapon::route('/create'),
            'view' => ViewWeapon::route('/{record}'),
            'edit' => EditWeapon::route('/{record}/edit'),
        ];
    }
}
