<?php

use App\Http\Controllers\JawabanController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('tugas', function () {
    return Inertia::render('Tugas');
})->middleware(['auth', 'verified'])->name('tugas');

Route::get('/tugas/{id}', function ($id) {
    return Inertia::render('TugasShow', ['id' => $id]);
});

// Tugas Routes
Route::middleware(['auth'])->group(function () {
    // api
    Route::get('/api/tugas', [TugasController::class, 'index']);
    Route::get('/api/tugas/{id}', [TugasController::class, 'show']);
    // Route::get('/tugas/create', [TugasController::class, 'create'])->middleware('can:dosen');
    // Route::post('/tugas', [TugasController::class, 'store'])->middleware('can:dosen');
    
    Route::get('/api/tugas/{tugas}/jawabans', [JawabanController::class, 'show']);
    Route::post('/api/tugas/{tugas}/jawaban', [JawabanController::class, 'store']);
    // Route::put('/jawaban/{id}/nilai', [JawabanController::class, 'updateNilai'])->middleware('can:dosen');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
