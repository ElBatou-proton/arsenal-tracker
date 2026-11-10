<?php

namespace App\Filament\Resources\WeaponAssignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Route;

class WeaponAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('weapon.serial_number')
                    ->label(__('weapon_assignments.table_columns.weapon_id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('weapon.serial_number')
                    ->label('Historial')
                    ->formatStateUsing(fn ($record) => 'Ver Historial')
                    ->url(fn ($record) => route('weapons.fullHistory', $record->weapon))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->icon('heroicon-o-clock'),
                TextColumn::make('owner.first_name')
                    ->label(__('weapon_assignments.table_columns.owner_id'))
                    ->formatStateUsing(fn ($record) => $record->owner ? "{$record->owner->first_name} {$record->owner->last_name}" : '-')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('assigned_by')
                    ->label(__('weapon_assignments.table_columns.assigned_by'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('entry_date')
                    ->label(__('weapon_assignments.table_columns.entry_date'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('reason')
                    ->label(__('weapon_assignments.table_columns.reason'))
                    ->searchable(),
                TextColumn::make('status.name')
                    ->label(__('weapon_assignments.table_columns.weapon_assignment_status_id'))
                    ->badge()
                    ->color(fn ($record) => $record->status?->color ?? 'gray'),
                TextColumn::make('destination')
                    ->label(__('weapon_assignments.table_columns.destination'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
