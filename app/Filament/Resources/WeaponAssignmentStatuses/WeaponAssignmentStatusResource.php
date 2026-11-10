<?php

namespace App\Filament\Resources\WeaponAssignmentStatuses;

use App\Filament\Resources\WeaponAssignmentStatuses\Pages\CreateWeaponAssignmentStatus;
use App\Filament\Resources\WeaponAssignmentStatuses\Pages\EditWeaponAssignmentStatus;
use App\Filament\Resources\WeaponAssignmentStatuses\Pages\ListWeaponAssignmentStatuses;
use App\Filament\Resources\WeaponAssignmentStatuses\Pages\ViewWeaponAssignmentStatus;
use App\Filament\Resources\WeaponAssignmentStatuses\Schemas\WeaponAssignmentStatusForm;
use App\Filament\Resources\WeaponAssignmentStatuses\Schemas\WeaponAssignmentStatusInfolist;
use App\Filament\Resources\WeaponAssignmentStatuses\Tables\WeaponAssignmentStatusesTable;
use App\Models\WeaponAssignmentStatus;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WeaponAssignmentStatusResource extends Resource
{
    protected static ?string $model = WeaponAssignmentStatus::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('weapon_assignment_statuses.resource_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('weapon_assignment_statuses.resource_label_plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('weapon_assignment_statuses.resource_label_plural');
    }

    public static function getNavigationGroup(): string
    {
        return __('weapon_assignment_statuses.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return WeaponAssignmentStatusForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WeaponAssignmentStatusInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeaponAssignmentStatusesTable::configure($table);
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
            'index' => ListWeaponAssignmentStatuses::route('/'),
            'create' => CreateWeaponAssignmentStatus::route('/create'),
            'view' => ViewWeaponAssignmentStatus::route('/{record}'),
            'edit' => EditWeaponAssignmentStatus::route('/{record}/edit'),
        ];
    }
}
