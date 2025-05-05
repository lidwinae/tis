<?php

use App\Http\Controllers\Api\JawabanController;
use App\Http\Controllers\Api\TugasController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function () {
    return response()->json(['message' => 'API bekerja!']);
});


Route::middleware(['auth:sanctum'])->group(function () {
    // api
    Route::get('/tugas', [TugasController::class, 'index']);
    Route::get('/tugas/{id}', [TugasController::class, 'show']);
    // Route::get('/tugas/create', [TugasController::class, 'create'])->middleware('can:dosen');
    // Route::post('/tugas', [TugasController::class, 'store'])->middleware('can:dosen');
    
    Route::get('/tugas/{tugas}/jawabans', [JawabanController::class, 'show']);
    Route::post('/tugas/{tugas}/jawaban', [JawabanController::class, 'store']);
    // Route::put('/jawaban/{id}/nilai', [JawabanController::class, 'updateNilai'])->middleware('can:dosen');
});
