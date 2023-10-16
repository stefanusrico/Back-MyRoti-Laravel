<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RegisterController;
use App\Http\Controllers\api\LapakController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::post('/registrasi', App\Http\Controllers\api\RegisterController::class)->name('registrasi');
Route::get('/registrasi', 'App\Http\Controllers\Api\RegisterController@getRole');
Route::post('/login', App\Http\Controllers\api\LoginController::class)->name('login');

//Lapak
Route::post('/lapak', 'App\Http\Controllers\Api\LapakController@addLapak');
Route::get('/lapak', 'App\Http\Controllers\Api\LapakController@getLapak');