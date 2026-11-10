<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\WeaponController::class, 'index'])->name('weapons.index');
Route::post('/weapons/search', [App\Http\Controllers\WeaponController::class, 'search'])->name('weapons.search');
Route::post('/weapons/{weapon}/assign', [App\Http\Controllers\WeaponController::class, 'assign'])->name('weapons.assign');
Route::post('/weapons/{weapon}/return', [App\Http\Controllers\WeaponController::class, 'return'])->name('weapons.return');
Route::post('/weapons/{weapon}/status', [App\Http\Controllers\WeaponController::class, 'updateStatus'])->name('weapons.updateStatus');
Route::get('/weapons/{weapon}/history', [App\Http\Controllers\WeaponController::class, 'history'])->name('weapons.history');
Route::get('/weapons/{weapon}/qr-code', [App\Http\Controllers\WeaponController::class, 'qrCode'])->name('weapons.qr-code');
Route::get('/weapons/{weapon}/full-history', [App\Http\Controllers\WeaponController::class, 'fullHistory'])->name('weapons.fullHistory');
Route::get('/weapons/{weapon}/export-history', [App\Http\Controllers\WeaponController::class, 'exportHistory'])->name('weapons.exportHistory');
Route::get('/report', [App\Http\Controllers\WeaponController::class, 'report'])->name('weapons.report');
Route::get('/report/export', [App\Http\Controllers\WeaponController::class, 'exportReport'])->name('weapons.exportReport');
Route::get('/api/owners', [App\Http\Controllers\WeaponController::class, 'getOwners']);
Route::get('/api/weapon-assignment-statuses', [App\Http\Controllers\WeaponController::class, 'getWeaponAssignmentStatuses']);
Route::get('/backup/download/{filename}', [App\Http\Controllers\BackupController::class, 'download'])->name('backup.download');
