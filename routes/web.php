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

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
