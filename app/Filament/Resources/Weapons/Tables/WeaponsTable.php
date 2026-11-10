<?php

namespace App\Filament\Resources\Weapons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WeaponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('weaponType.name')
                    ->label(__('weapons.table_columns.weapon_type'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('model')
                    ->label(__('weapons.table_columns.model'))
                    ->searchable(),
                TextColumn::make('serial_number')
                    ->label(__('weapons.table_columns.serial_number'))
                    ->searchable(),
                TextColumn::make('intake_date')
                    ->label(__('weapons.table_columns.intake_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('intake_time')
                    ->label(__('weapons.table_columns.intake_time'))
                    ->time()
                    ->sortable(),
                TextColumn::make('owner.first_name')
                    ->label(__('weapons.table_columns.owner'))
                    ->formatStateUsing(fn ($record) => $record->owner ? "{$record->owner->first_name} {$record->owner->last_name}" : __('weapons.table_columns.no_owner'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
