<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublikasiController;

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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index']);
    Route::post('/publikasi', [PublikasiController::class, 'store']);
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    // Publikasi detail
    Route::get('/publikasi/{publikasi}', [PublikasiController::class, 'show']);
    Route::put('/publikasi/{publikasi}', [PublikasiController::class,'update']);
    Route::delete('/publikasi/{publikasi}', [PublikasiController::class, 'destroy']);
});

