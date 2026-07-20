<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityLogController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('activities', ActivityController::class);
    Route::get('activities/{activity}/log', [ActivityLogController::class, 'create'])->name('activities.log.create');
    Route::post('activities/{activity}/log', [ActivityLogController::class, 'store'])->name('activities.log.store');
});

require __DIR__.'/settings.php';