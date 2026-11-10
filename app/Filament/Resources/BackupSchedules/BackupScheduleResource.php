<?php

namespace App\Filament\Resources\BackupSchedules;

use App\Filament\Resources\BackupSchedules\Pages\CreateBackupSchedule;
use App\Filament\Resources\BackupSchedules\Pages\EditBackupSchedule;
use App\Filament\Resources\BackupSchedules\Pages\ListBackupSchedules;
use App\Filament\Resources\BackupSchedules\Schemas\BackupScheduleForm;
use App\Filament\Resources\BackupSchedules\Tables\BackupSchedulesTable;
use App\Models\BackupSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BackupScheduleResource extends Resource
{
    protected static ?string $model = BackupSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $navigationLabel = 'Programas de Backup';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BackupScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BackupSchedulesTable::configure($table);
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
            'index' => ListBackupSchedules::route('/'),
            'create' => CreateBackupSchedule::route('/create'),
            'edit' => EditBackupSchedule::route('/{record}/edit'),
        ];
    }
}
