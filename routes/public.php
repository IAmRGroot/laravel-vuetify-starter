<?php

use App\Http\Controllers\VueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', [VueController::class, 'page']);
