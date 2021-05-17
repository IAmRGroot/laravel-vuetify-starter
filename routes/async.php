<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Async (authenticated) Routes
|--------------------------------------------------------------------------
|
*/

Route::any('ping', static function (): string {
    return 'pong';
});

Route::post('login', [LoginController::class, 'login']);
// Route::post('user', [LoginController::class, 'login']);
