<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\AreaController;
use App\Http\Controllers\api\RotiController;
use App\Http\Controllers\api\KurirController;
use App\Http\Controllers\api\AlokasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;


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
Route::get('/lapak/{id}', 'App\Http\Controllers\Api\LapakController@showData');
Route::delete('/lapak/{id}', 'App\Http\Controllers\Api\LapakController@deleteLapak');
Route::put('/update-lapak/{id}', 'App\Http\Controllers\Api\LapakController@updateLapak');

Route::post('/area', [AreaController::class, 'store']);

Route::get('/data-kurir', [AdminController::class, 'getDataKurir']);
Route::get('/data-kurir/{id}', [AdminController::class, 'getDataKurirById']);
Route::get('/kurir-by-area', [KurirController::class, 'getKurirByArea']);
Route::get('/kurir', 'App\Http\Controllers\api\KurirController@getKurir');
Route::get('/kurir/{id}', 'App\Http\Controllers\api\KurirController@showData');
Route::put('/update-kurir/{id}', 'App\Http\Controllers\api\AdminController@updateKurir');
Route::put('/update-user-password/{id}', 'App\Http\Controllers\api\AdminController@updateKurirPassword');


Route::get('/data-koordinator', [AdminController::class, 'getDataKoordinator']);
Route::get('/data-keuangan', [AdminController::class, 'getDataKeuangan']);
Route::get('/data-kurir', [AdminController::class, 'getDataKurir']);

Route::post('/roti', 'App\Http\Controllers\Api\RotiController@addRoti');
Route::get('/roti', 'App\Http\Controllers\Api\RotiController@getRoti');
//test