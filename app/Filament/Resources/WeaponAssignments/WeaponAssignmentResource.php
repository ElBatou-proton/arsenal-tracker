<?php

namespace App\Filament\Resources\WeaponAssignments;

use App\Filament\Resources\WeaponAssignments\Pages\CreateWeaponAssignment;
use App\Filament\Resources\WeaponAssignments\Pages\EditWeaponAssignment;
use App\Filament\Resources\WeaponAssignments\Pages\ListWeaponAssignments;
use App\Filament\Resources\WeaponAssignments\Pages\ViewWeaponAssignment;
use App\Filament\Resources\WeaponAssignments\Schemas\WeaponAssignmentForm;
use App\Filament\Resources\WeaponAssignments\Schemas\WeaponAssignmentInfolist;
use App\Filament\Resources\WeaponAssignments\Tables\WeaponAssignmentsTable;
use App\Models\WeaponAssignment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WeaponAssignmentResource extends Resource
{
    protected static ?string $model = WeaponAssignment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getModelLabel(): string
    {
        return __('weapon_assignments.resource_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('weapon_assignments.resource_label_plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('weapon_assignments.resource_label_plural');
    }

    public static function getNavigationGroup(): string
    {
        return __('weapon_assignments.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return WeaponAssignmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WeaponAssignmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeaponAssignmentsTable::configure($table);
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
            'index' => ListWeaponAssignments::route('/'),
            'create' => CreateWeaponAssignment::route('/create'),
            'view' => ViewWeaponAssignment::route('/{record}'),
            'edit' => EditWeaponAssignment::route('/{record}/edit'),
        ];
    }
}
