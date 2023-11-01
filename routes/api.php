<?php

use App\Http\Controllers\api\AreaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\KurirController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/lapak', 'App\Http\Controllers\Api\LapakController@addLapak');
Route::get('/lapak', 'App\Http\Controllers\Api\LapakController@getLapak');
Route::delete('/lapak/{id}', 'App\Http\Controllers\Api\LapakController@deleteLapak');

Route::post('/area', [AreaController::class, 'store']);


Route::get('/kurir-by-area', [KurirController::class, 'getKurirByArea']);