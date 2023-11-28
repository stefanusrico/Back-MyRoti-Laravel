<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\AreaController;
use App\Http\Controllers\api\RotiController;
use App\Http\Controllers\api\KurirController;
use App\Http\Controllers\api\RoleController;
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
Route::post('/store-role', [RoleController::class, 'store']);

Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('get-amount-koordinator', 'App\Http\Controllers\api\AdminController@getAmountKoordinator');
    Route::delete('/delete-koordinator/{id}', 'App\Http\Controllers\api\AdminController@deleteKoordinator');
    Route::put('/update-koordinator/{id}', 'App\Http\Controllers\api\AdminController@updateKoordinator');
    Route::put('/update-koordinator-password/{id}', 'App\Http\Controllers\api\AdminController@updateKoordinatorPassword');
    Route::get('get-amount-keuangan', 'App\Http\Controllers\api\AdminController@getAmountKeuangan');
    Route::delete('/delete-keuangan/{id}', 'App\Http\Controllers\api\AdminController@deleteKeuangan');
    Route::put('/update-keuangan/{id}', 'App\Http\Controllers\api\AdminController@updateKeuangan');
    Route::put('/update-keuangan-password/{id}', 'App\Http\Controllers\api\AdminController@updateKeuanganPassword');
    Route::get('/data-koordinator', [AdminController::class, 'getDataKoordinator']);
    Route::get('/data-koordinator/{id}', [AdminController::class, 'getDataKoordinatorById']);
    Route::get('/data-keuangan', [AdminController::class, 'getDataKeuangan']);
    Route::get('/data-keuangan/{id}', [AdminController::class, 'getDataKeuanganById']);
    Route::get('/data-kurir', [AdminController::class, 'getDataKurir']);
    Route::get('/data-kurir/{id}', [AdminController::class, 'getDataKurirById']);
    Route::put('/update-kurir/{id}', 'App\Http\Controllers\api\AdminController@updateKurir');
    Route::put('/update-kurir-password/{id}', 'App\Http\Controllers\api\AdminController@updateKurirPassword');
    Route::delete('/delete-kurir/{id}', 'App\Http\Controllers\api\AdminController@deleteKurir');
    Route::get('get-amount-kurir', 'App\Http\Controllers\api\AdminController@getAmountKurir');
    Route::get('get-amount-user', 'App\Http\Controllers\api\AdminController@getAmountUser');
});

Route::middleware(['auth', 'check.role:koordinator'])->group(function () {
    Route::post('/lapak', 'App\Http\Controllers\Api\LapakController@addLapak');
    Route::get('/lapak', 'App\Http\Controllers\Api\LapakController@getLapak');
    Route::put('/update-lapak/{id}', 'App\Http\Controllers\Api\LapakController@updateLapak');
    Route::put('/lapak/{id}', 'App\Http\Controllers\Api\LapakController@updateKurirIdLapak');
    Route::get('/lapak/{id}', 'App\Http\Controllers\Api\LapakController@showData');
    Route::delete('/lapak/{id}', 'App\Http\Controllers\Api\LapakController@deleteLapak');
    Route::get('/lapak-id/{id}', 'App\Http\Controllers\Api\LapakController@getLapakById');
    Route::get('/lapak-area/{id}', 'App\Http\Controllers\Api\LapakController@getLapakByArea');    
});

Route::post('/area', [AreaController::class, 'store']);
Route::get('/area', 'App\Http\Controllers\api\AreaController@getArea'); 

Route::middleware(['auth', 'check.role:koordinator'])->group(function () {
    Route::get('/kurir-by-area', [KurirController::class, 'getKurirByArea']);
    Route::get('/kurir', 'App\Http\Controllers\api\KurirController@getKurir');
    Route::get('/kurir/{id}', 'App\Http\Controllers\api\KurirController@showData');
    Route::get('/get-nama-kurir', [KurirController::class, 'namaKurir']);
    Route::post('/alokasi', 'App\Http\Controllers\Api\AlokasiController@addAlokasi');
    Route::get('/alokasi', 'App\Http\Controllers\Api\AlokasiController@getAlokasi');
    Route::get('/alokasi/{id}', 'App\Http\Controllers\Api\AlokasiController@getAlokasiByLapak');
    Route::get('/alokasi-keterangan/{id}', 'App\Http\Controllers\Api\AlokasiController@getAlokasiByKeterangan');
    Route::put('/alokasi/{id}', 'App\Http\Controllers\Api\AlokasiController@updateKeteranganAlokasi');
    Route::delete('/alokasi/{id}', 'App\Http\Controllers\Api\AlokasiController@deleteAlokasi');
    Route::post('/roti', 'App\Http\Controllers\Api\RotiController@addRoti');
    Route::get('/roti', 'App\Http\Controllers\Api\RotiController@getRoti');
    Route::get('/roti-dd/{id}', 'App\Http\Controllers\Api\RotiController@rotiData');
    Route::get('/roti/{id}', 'App\Http\Controllers\Api\RotiController@showData');
    
});
