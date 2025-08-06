<?php

use App\Http\Controllers\ProjectManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Main project management route
Route::controller(ProjectManagementController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'store')->name('projects.store')->middleware(['auth', 'verified']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProjectManagementController::class, 'index'])->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
