<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Facades\App\Manager\CloudStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    /**
     * Hiển thị danh sách các thư mục, tệp tin nằm bên trong $path.
     *
     * @param Request $request
     * @param Account $account Tài khoản
     * @param string  $path    Thư mục cần mở
     *
     * @return View
     */
    public function show(Request $request, Account $account, string $path): View
    {
        $storage = CloudStorage::driver($account->provider);
        $storage->setToken($account->token());

        $path = base64_decode($path);

        $directories = collect($storage->directories($path))->map(function (array $directory) use ($account) {
            $directory['account'] = $account;

            return $directory;
        });

        $files = collect($storage->files($path))->map(function (array $file) use ($account) {
            $file['account'] = $account;

            return $file;
        });

        return view('pages.show-directory', compact('files', 'directories'));
    }
}
