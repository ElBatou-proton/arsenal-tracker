<?php

namespace App\Filament\Resources\WeaponTypes;

use App\Filament\Resources\WeaponTypes\Pages\CreateWeaponType;
use App\Filament\Resources\WeaponTypes\Pages\EditWeaponType;
use App\Filament\Resources\WeaponTypes\Pages\ListWeaponTypes;
use App\Filament\Resources\WeaponTypes\Pages\ViewWeaponType;
use App\Filament\Resources\WeaponTypes\Schemas\WeaponTypeForm;
use App\Filament\Resources\WeaponTypes\Schemas\WeaponTypeInfolist;
use App\Filament\Resources\WeaponTypes\Tables\WeaponTypesTable;
use App\Models\WeaponType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WeaponTypeResource extends Resource
{
    protected static ?string $model = WeaponType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('weapon_types.resource_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('weapon_types.resource_label_plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('weapon_types.resource_label_plural');
    }

    public static function getNavigationGroup(): string
    {
        return __('weapon_types.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return WeaponTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WeaponTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeaponTypesTable::configure($table);
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
            'index' => ListWeaponTypes::route('/'),
            'create' => CreateWeaponType::route('/create'),
            'view' => ViewWeaponType::route('/{record}'),
            'edit' => EditWeaponType::route('/{record}/edit'),
        ];
    }
}
