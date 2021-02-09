<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Utils\StorageUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * @dev Chỉ mới hiện các tệp tin để kiểm thử
     * @return View
     */
    public function index(): View
    {
        /** @var Account[] $accounts */
        $accounts = auth()->user()->cloudStorage()->get();

        foreach ($accounts as $account) {
            dump("Kho lưu trữ: {$account->provider->label} | Tài khoản: {$account->email}");
            StorageUtils::setAccessToken($account->provider, $account);
            $files = Storage::disk($account->provider->value)->listContents('/', false);
            StorageUtils::clearGoogleAccessToken();
            dump($files);
        }

        return view('dashboard');
    }
}
