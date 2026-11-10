<?php

namespace App\Filament\Resources\Owners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OwnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label(__('owners.table_columns.first_name'))
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label(__('owners.table_columns.last_name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('owners.table_columns.email'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('owners.table_columns.phone'))
                    ->searchable(),
                TextColumn::make('rank.abbreviation')
                    ->label(__('owners.table_columns.rank'))
                    ->sortable(),
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
