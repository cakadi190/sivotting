<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/pilih', [\App\Http\Controllers\HomeController::class, 'vote'])->name('vote');
Route::get('/pilih/{id}', [\App\Http\Controllers\HomeController::class, 'votting'])->name('votting');
