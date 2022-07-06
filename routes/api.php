<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])
    ->middleware(['auth:api']);

Route::get('/posts', [BlogController::class, 'index']);
Route::post('/posts', [BlogController::class, 'store'])
    ->middleware(['auth:api']);
Route::delete('/posts', [BlogController::class, 'destroy'])
    ->middleware(['auth:api']);


