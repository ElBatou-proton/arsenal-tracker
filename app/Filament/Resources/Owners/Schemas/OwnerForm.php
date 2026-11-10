<?php

namespace App\Filament\Resources\Owners\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class OwnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label(__('owners.first_name'))
                    ->required(),
                TextInput::make('last_name')
                    ->label(__('owners.last_name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('owners.email'))
                    ->email()
                    ->nullable()
                    ->unique(ignoreRecord: true),
                TextInput::make('phone')
                    ->label(__('owners.phone'))
                    ->tel(),
                Select::make('rank_id')
                    ->label(__('owners.rank'))
                    ->relationship('rank', 'name')
                    ->nullable(),
            ]);
    }
}
