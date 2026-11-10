<?php

namespace App\Http\Controllers;

use App\Services\DatabaseBackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BackupController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function download(Request $request, string $filename)
    {
        $service = new DatabaseBackupService();
        $filepath = $service->getBackupPath($filename);
        
        if (!file_exists($filepath)) {
            abort(404, 'Backup file not found');
        }

        return Response::download($filepath, $filename);
    }
}