<?php

namespace App\Filament\Resources\BackupSchedules\Pages;

use App\Filament\Resources\BackupSchedules\BackupScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBackupSchedule extends EditRecord
{
    protected static string $resource = BackupScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
