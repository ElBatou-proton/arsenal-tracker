<?php

namespace App\Filament\Pages;

use App\Services\DatabaseBackupService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Response;

class DatabaseBackup extends Page
{
    // Fix: Explicitly use the exact type signature Filament requires
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-archive-box';
    
    protected static ?string $navigationLabel = 'Database Backup';
    
    protected string $view = 'filament.pages.database-backup';
    
    protected static ?int $navigationSort = 100;

    public array $backups = [];

    public function mount(): void
    {
        $this->loadBackups();
    }

    public function loadBackups(): void
    {
        $service = new DatabaseBackupService();
        $this->backups = $service->listBackups();
    }

    public function generateBackup(): void
    {
        try {
            $service = new DatabaseBackupService();
            $filename = $service->generateBackup();
            
            Notification::make()
                ->title('Backup created successfully')
                ->body("Backup file: {$filename}")
                ->success()
                ->send();
            
            $this->loadBackups();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Backup failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function deleteBackup(string $filename): void
    {
        try {
            $service = new DatabaseBackupService();
            $service->deleteBackup($filename);
            
            Notification::make()
                ->title('Backup deleted')
                ->success()
                ->send();
            
            $this->loadBackups();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Delete failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Backup')
                ->icon('heroicon-o-plus')
                ->action('generateBackup')
                ->requiresConfirmation(),
        ];
    }
}