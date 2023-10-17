<?php

use App\Http\Controllers\Api\DataKeuangan;
use App\Http\Controllers\Api\DataKurir;
use App\Http\Controllers\Api\DataKoordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RegisterController;
use App\Http\Controllers\api\LapakController;
<<<<<<< Updated upstream
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\KurirController;


=======
use App\Http\Controllers\Api\KurirController;
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream

//admin
Route::get('/getData', [KurirController::class, 'getData']);

=======
Route::put('/lapak/{id}', 'App\Http\Controllers\Api\LapakController@updateLapak');
Route::delete('/lapak/{id}', 'App\Http\Controllers\Api\LapakController@deleteLapak');

//Admin
Route::get('/data-kurir', [DataKurir::class, 'getData']);
Route::get('/data-koordinator', [DataKoordinator::class, 'getData']);
Route::get('/data-keuangan', [DataKeuangan::class, 'getData']);
>>>>>>> Stashed changes
