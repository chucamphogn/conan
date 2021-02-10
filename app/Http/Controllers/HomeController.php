<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Facades\App\Manager\CloudStorage;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * @dev Chỉ mới hiện các tệp tin để kiểm thử
     *
     * @return View
     */
    public function index(): View
    {
        /** @var Account[] $accounts */
        $accounts = auth()->user()->cloudStorage()->get();

        foreach ($accounts as $account) {
            $storage = CloudStorage::driver($account->provider->value);
            $storage->setToken($account->toArray());
            $files = $storage->listContents('/', false);
            dump($files);
        }

        return view('dashboard');
    }
}
