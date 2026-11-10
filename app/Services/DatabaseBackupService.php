<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DatabaseBackupService
{
    public function generateBackup(): string
    {
        $connection = config('database.default');
        $backupPath = storage_path('app/backups');
        
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $filename = 'backup_' . Carbon::now()->setTimezone(config('app.timezone'))->format('Y-m-d_H-i-s') . '.sql';
        $filepath = $backupPath . '/' . $filename;

        switch ($connection) {
            case 'sqlite':
                $this->backupSqlite($filepath);
                break;
            case 'mysql':
            case 'mariadb':
                $this->backupMysql($filepath);
                break;
            case 'pgsql':
                $this->backupPostgres($filepath);
                break;
            default:
                throw new \Exception("Database driver {$connection} not supported for backup");
        }

        return $filename;
    }

    private function backupSqlite(string $filepath): void
    {
        $databasePath = config('database.connections.sqlite.database');
        
        if (!File::exists($databasePath)) {
            throw new \Exception("SQLite database file not found: {$databasePath}");
        }

        // Use sqlite3 command to generate SQL dump
        $command = sprintf(
            'sqlite3 %s .dump > %s',
            escapeshellarg($databasePath),
            escapeshellarg($filepath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception("SQLite backup failed. Return code: {$returnCode}");
        }
    }

    private function backupMysql(string $filepath): void
    {
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port', 3306);
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s --skip-ssl %s > %s',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($filepath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception("MySQL backup failed. Return code: {$returnCode}");
        }
    }

    private function backupPostgres(string $filepath): void
    {
        $host = config('database.connections.pgsql.host');
        $port = config('database.connections.pgsql.port', 5432);
        $database = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $password = config('database.connections.pgsql.password');

        // Set PGPASSWORD environment variable for pg_dump
        putenv('PGPASSWORD=' . $password);

        $command = sprintf(
            'pg_dump --host=%s --port=%s --username=%s --dbname=%s > %s',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($database),
            escapeshellarg($filepath)
        );

        exec($command, $output, $returnCode);

        // Clear the environment variable
        putenv('PGPASSWORD');

        if ($returnCode !== 0) {
            throw new \Exception("PostgreSQL backup failed. Return code: {$returnCode}");
        }
    }

    public function getBackupPath(string $filename): string
    {
        return storage_path('app/backups/' . $filename);
    }

    public function listBackups(): array
    {
        $backupPath = storage_path('app/backups');
        
        if (!File::exists($backupPath)) {
            return [];
        }

        $files = File::files($backupPath);
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'filename' => $file->getFilename(),
                'size' => $this->formatFileSize($file->getSize()),
                'created_at' => Carbon::createFromTimestampUTC($file->getMTime())->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s'),
            ];
        }

        return array_reverse($backups); // Show newest first
    }

    public function deleteBackup(string $filename): bool
    {
        $filepath = $this->getBackupPath($filename);
        
        if (File::exists($filepath)) {
            return File::delete($filepath);
        }

        return false;
    }

    private function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}