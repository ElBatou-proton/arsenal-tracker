<?php

namespace App\Filament\Resources\Ranks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('ranks.name'))
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('abbreviation')
                    ->label(__('ranks.abbreviation'))
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('order')
                    ->label(__('ranks.order'))
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('description')
                    ->label(__('ranks.description'))
                    ->columnSpanFull(),
            ]);
    }
}
