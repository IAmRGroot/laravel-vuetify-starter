<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

/*
 * 404 all other routes
 */

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('user', [LoginController::class, 'user'])
    ->middleware('auth:sanctum')
    ->name('user');
