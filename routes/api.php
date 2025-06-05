<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\PenghuniController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Route::apiResource('penghuni', PenghuniController::class);
Route::get('penghuni', [PenghuniController::class, 'index']);
Route::post('penghuni', [PenghuniController::class, 'store']);
Route::get('penghuni/{id}', [PenghuniController::class, 'show']);
Route::put('penghuni/{id}', [PenghuniController::class, 'update']);

// route rumah
Route::get('/rumah', [RumahController::class, 'index']);
Route::post('/rumah', [RumahController::class, 'store']);
Route::put('/rumah/{id}', [RumahController::class, 'update']);
Route::post('/rumah/{id}/penghuni', [RumahController::class, 'tambahPenghuni']);
Route::get('/rumah/{id}/histori-penghuni', [RumahController::class, 'historiPenghuni']);
Route::get('/rumah/{id}/pembayaran', [RumahController::class, 'historiPembayaran']);