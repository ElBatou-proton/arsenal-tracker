<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BackupSchedule;
use App\Services\DatabaseBackupService;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class RunScheduledBackups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-scheduled-backups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled database backups based on configured schedules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for scheduled backups...');

        $schedules = BackupSchedule::where('is_active', true)->get();

        if ($schedules->isEmpty()) {
            $this->info('No active backup schedules found.');
            return 0;
        }

        $backupService = new DatabaseBackupService();
        $runCount = 0;

        foreach ($schedules as $schedule) {
            if ($this->isDue($schedule)) {
                $this->info("Running backup for schedule: {$schedule->name}");

                try {
                    $filename = $backupService->generateBackup();
                    $this->info("Backup created: {$filename}");

                    $schedule->update([
                        'last_run_at' => Carbon::now(),
                        'next_run_at' => $this->calculateNextRun($schedule->expression),
                    ]);

                    $this->cleanupOldBackups($schedule->retention_days);
                    $runCount++;
                } catch (\Exception $e) {
                    $this->error("Backup failed for schedule {$schedule->name}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Completed. Ran {$runCount} backup(s).");
        return 0;
    }

    private function isDue(BackupSchedule $schedule): bool
    {
        if (!$schedule->next_run_at) {
            return true;
        }

        return Carbon::now()->gte($schedule->next_run_at);
    }

    private function calculateNextRun(string $expression): Carbon
    {
        // Simplified cron parser for common patterns
        $parts = explode(' ', $expression);
        $minute = $parts[0];
        $hour = $parts[1];
        $day = $parts[2];
        $month = $parts[3];
        $weekday = $parts[4];

        $nextRun = Carbon::now()->addMinute(); // Start with next minute

        // Handle minute
        if ($minute !== '*') {
            if (str_contains($minute, '/')) {
                // Handle intervals like */30
                [$base, $interval] = explode('/', $minute);
                $currentMinute = $nextRun->minute;
                $nextMinute = ceil($currentMinute / (int)$interval) * (int)$interval;
                if ($nextMinute > 59) {
                    $nextMinute = 0;
                    $nextRun->addHour();
                }
                $nextRun->minute($nextMinute);
            } else {
                $nextRun->minute((int)$minute);
            }
        }

        // Handle hour
        if ($hour !== '*') {
            if (str_contains($hour, '/')) {
                [$base, $interval] = explode('/', $hour);
                $currentHour = $nextRun->hour;
                $nextHour = ceil($currentHour / (int)$interval) * (int)$interval;
                if ($nextHour > 23) {
                    $nextHour = 0;
                    $nextRun->addDay();
                }
                $nextRun->hour($nextHour);
            } else {
                $nextRun->hour((int)$hour);
            }
        }

        // Handle day
        if ($day !== '*') {
            $nextRun->day((int)$day);
        }

        // Handle month
        if ($month !== '*') {
            $nextRun->month((int)$month);
        }

        // Handle weekday (0 = Sunday, 6 = Saturday)
        if ($weekday !== '*') {
            $nextRun->weekday((int)$weekday);
        }

        // Ensure next run is in the future
        if ($nextRun->lte(Carbon::now())) {
            $nextRun->addHour();
        }

        return $nextRun;
    }

    private function cleanupOldBackups(int $retentionDays): void
    {
        $backupPath = storage_path('app/backups');

        if (!File::exists($backupPath)) {
            return;
        }

        $files = File::files($backupPath);
        $cutoffDate = Carbon::now()->subDays($retentionDays);

        foreach ($files as $file) {
            if (Carbon::createFromTimestampUTC($file->getMTime())->setTimezone(config('app.timezone'))->lt($cutoffDate)) {
                File::delete($file->getPathname());
                $this->info("Deleted old backup: {$file->getFilename()}");
            }
        }
    }
}
