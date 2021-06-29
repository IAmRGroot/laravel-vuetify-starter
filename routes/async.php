<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Maintenance\MaintenanceController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*
|--------------------------------------------------------------------------
| Async (public) Routes
|--------------------------------------------------------------------------
|
*/

Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('csrf', [CsrfCookieController::class, 'show'])->name('csrf');

/*
|--------------------------------------------------------------------------
| Async (authenticated) Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth')->group(static function (): void {
    Route::get('user', [LoginController::class, 'user'])->name('user');

    MaintenanceController::routes();
});


/*
 * 404 all other routes
 */
Route::any('/{route?}', static function (): void {
    abort(Response::HTTP_NOT_FOUND);
})->where('route', '^.+$');