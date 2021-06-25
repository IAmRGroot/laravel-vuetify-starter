<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Maintenance\MaintenanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Async (authenticated) Routes
|--------------------------------------------------------------------------
|
*/

Route::any('ping', static function (): string {
    return 'pong';
})->name('ping');

Route::post('login', [LoginController::class, 'login'])->name('login');
// Route::post('user', [LoginController::class, 'login'])->name('login.post');

MaintenanceController::routes();
