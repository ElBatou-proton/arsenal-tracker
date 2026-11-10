<?php

namespace App\Filament\Resources\BackupSchedules\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class BackupScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Configuración del programa')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        Select::make('expression')
                            ->label('Frecuencia')
                            ->options([
                                '0 0 * * *' => 'Diariamente a medianoche',
                                '0 0 * * 0' => 'Semanalmente (domingo a medianoche)',
                                '0 0 1 * *' => 'Mensualmente (1ero del mes a medianoche)',
                                '0 */6 * * *' => 'Cada 6 horas',
                                '0 */12 * * *' => 'Cada 12 horas',
                                '0 * * * *' => 'Cada hora',
                                '*/30 * * * *' => 'Cada 30 minutos',
                            ])
                            ->required()
                            ->helperText('Expresión cron para la frecuencia de backup'),
                        TextInput::make('retention_days')
                            ->label('Días de retención')
                            ->numeric()
                            ->default(30)
                            ->required()
                            ->helperText('Eliminar backups más antiguos que este número de días'),
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),
                    ]),
            ]);
    }
}
