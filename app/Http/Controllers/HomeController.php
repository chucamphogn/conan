<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Facades\App\Manager\CloudStorage;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Chuyển đến trang thêm tài khoản lưu trữ đám mây.
     *
     * @return View
     */
    public function addCloudStorage(): View
    {
        return view('pages.add-cloud-storage');
    }

    /**
     * @dev Chỉ mới hiện các tệp tin để kiểm thử
     *
     * @return View
     */
    public function index(): View
    {
        /** @var Account[] $accounts */
        $accounts = auth()->user()->cloudStorageAccounts()->get();
        $files = collect();

        foreach ($accounts as $account) {
            $storage = CloudStorage::driver($account->provider);
            $storage->setToken($account->token());
            $files->add( $storage->listContents('/', false));
        }

        return view('pages.dashboard', compact('files'));
    }
}
