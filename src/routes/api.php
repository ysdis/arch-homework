<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\MetricController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/'], static function () {
    Route::get('health', [HealthController::class, 'health'])->name('health.check');
    Route::get('metrics', [MetricController::class, 'metrics'])->name('metrics.check');

    Route::resource('user', UserController::class)->only([
        'show', 'store', 'update', 'destroy',
    ]);
});
