<?php

use App\Http\Controllers\IuranController;
use App\Http\Controllers\LaporanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\SaldoBulananController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Route::apiResource('penghuni', PenghuniController::class);
Route::get('penghuni', [PenghuniController::class, 'index']);
Route::post('penghuni', [PenghuniController::class, 'store']);
Route::get('penghuni/{id}', [PenghuniController::class, 'show']);
Route::put('penghuni/{id}', [PenghuniController::class, 'update']);
Route::delete('penghuni/{id}', [PenghuniController::class, 'destroy']);

// route rumah
Route::get('/rumah', [RumahController::class, 'index']);
Route::post('/rumah', [RumahController::class, 'store']);
Route::get('/rumah/{id}', [RumahController::class, 'show']);
Route::put('/rumah/{id}', [RumahController::class, 'update']);

Route::get('/penghuni-rumah', [RumahController::class, 'getAllPenghuniRumah']);
Route::post('/rumah/{id}/penghuni', [RumahController::class, 'tambahPenghuni']);
Route::put('/rumah/{id}/update_penghuni', [RumahController::class, 'updatePenghuniRumah']);
Route::get('/rumah/{id}/histori_penghuni', [RumahController::class, 'historiPenghuni']);
Route::get('/rumah/{id}/histori_pembayaran', [RumahController::class, 'historiPembayaran']);
Route::delete('/rumah/{id}', [RumahController::class, 'destroy']);
Route::delete('/penghuni-rumah/{id}', [RumahController::class, 'deletePenghuniRumah']);

//Api Iuran 
Route::get('/iuran', [IuranController::class, 'index']);
Route::post('/iuran', [IuranController::class, 'store']);
//Api Pembayaran 
Route::post('/pembayaran', [PembayaranController::class, 'store']);
Route::post('/pengeluaran', [PengeluaranController::class, 'store']);
Route::get('/pembayaran', [PembayaranController::class, 'index']);
Route::get('/pembayaran/{id_rumah}', [PembayaranController::class, 'riwayatRumah']);
Route::patch('/pembayaran/{id}/lunas', [PembayaranController::class, 'updateStatus']);
Route::post('/saldo/rekap-bulanan', [SaldoBulananController::class, 'storeMonthlySummary']);


//Api Laporan
Route::get('/report/grafik-tahunan', [LaporanController::class, 'grafikTahunan']);
Route::post('/report/bulanan', [LaporanController::class, 'detailBulanan']);
Route::get('/laporan/history-pembayaran', [LaporanController::class, 'historyPembayaran']);
