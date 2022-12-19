<?php

use Illuminate\Support\Facades\Route;

# Login
Route::prefix('/login')->name('login.')->group(function() {
    Route::view('/', 'admin.login.index')->name('home');
    Route::post('/', [\App\Http\Controllers\admin\LoginController::class, 'login'])->name('auth');
    Route::get('/logout', [\App\Http\Controllers\admin\LoginController::class, 'logout'])->name('logout');
});

# Admin Panel
Route::prefix('/')->middleware('auth.admin')->name('admin.')->group(function() {
    Route::view('/', 'admin.welcome')->name('home');
    Route::get('/result', \App\Http\Controllers\admin\ElectronResultController::class)->name('election-result');

    Route::get('manage/user/truncate', [\App\Http\Controllers\admin\UserManageController::class, 'truncating'])->name('user.truncate');
    Route::get('manage/class/truncate', [\App\Http\Controllers\admin\ClassManageController::class, 'truncating'])->name('classroom.truncate');
    Route::get('manage/candidate/truncate', [\App\Http\Controllers\admin\CandidateManageController::class, 'truncating'])->name('candidate.truncate');

    Route::resources([
        'manage/classroom' => \App\Http\Controllers\admin\ClassManageController::class,
        'manage/candidate' => \App\Http\Controllers\admin\CandidateManageController::class,
        'manage/user'      => \App\Http\Controllers\admin\UserManageController::class,
    ]);
});
