<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

use Illuminate\Support\Facades\Route;

Route::get('*', [VueController::class, 'page']);
