<?php

use App\Http\Controllers\VueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

$skipped_prefixes = ['api\/', 'async\/', 'assets\/'];
$skipped_prefixes = implode('|', $skipped_prefixes);

Route::get('/login', [VueController::class, 'page'])
    ->name('login');

Route::get('/{route?}', [VueController::class, 'page'])
    ->where('route', "^(?!({$skipped_prefixes})).*$")
    ->name('home');
