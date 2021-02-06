<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Services\GoogleServiceController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    // Đăng nhập Google
    Route::get('/account/add-account-google', [GoogleServiceController::class, 'redirectToGoogleLogin'])
        ->name('account.add-account-google');
    // Xử lý callback của Google
    Route::get('/account/google-callback', [GoogleServiceController::class, 'handleGoogleCallback']);
});
