<?php

use App\Http\Controllers\API\FileController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Services\RegisterDropboxServiceController;
use App\Http\Controllers\Services\RegisterGoogleServiceController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    // Dẫn đến trang thêm kho lưu trữ đám mây
    Route::get('/add-cloud-storage', [HomeController::class, 'addCloudStorage'])->name('account.add-cloud-storage');

    // Xử lý thêm tài khoản Google
    Route::get('/account/add-account-google', [RegisterGoogleServiceController::class, 'redirectProviderLogin'])
        ->name('account.add-account-google');
    Route::get('/account/google-callback', [RegisterGoogleServiceController::class, 'handleProviderCallback']);

    // Xử lý thêm tài khoản Dropbox
    Route::get('/account/add-account-dropbox', [RegisterDropboxServiceController::class, 'redirectProviderLogin'])
        ->name('account.add-account-dropbox');
    Route::get('/account/dropbox-callback', [RegisterDropboxServiceController::class, 'handleProviderCallback']);

    // Thay đổi tên tệp tin, thư mục
    Route::put('files/rename', [FileController::class, 'rename']);

    // Mở thư mục
    Route::get('directory/{account}/{path}', [DirectoryController::class, 'show'])
        ->name('directory.show');
});
