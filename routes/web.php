<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Services\RegisterDropboxServiceController;
use App\Http\Controllers\Services\RegisterGoogleServiceController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    /**
     * Xử lý thêm tài khoản Google
     */
    Route::get('/account/add-account-google', [RegisterGoogleServiceController::class, 'redirectProviderLogin'])
        ->name('account.add-account-google');
    Route::get('/account/google-callback', [RegisterGoogleServiceController::class, 'handleProviderCallback']);

    /**
     * Xử lý thêm tài khoản Dropbox
     */
    Route::get('/account/add-account-dropbox', [RegisterDropboxServiceController::class, 'redirectProviderLogin'])
        ->name('account.add-account-dropbox');
    Route::get('/account/dropbox-callback', [RegisterDropboxServiceController::class, 'handleProviderCallback']);
});
