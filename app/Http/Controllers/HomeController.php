<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Facades\App\Manager\CloudStorage;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Số lượng thư mục tối đa sẽ hiển thị trên giao diện.
     */
    private const MAX_NUMBER_OF_DIRECTORY = 10;

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

        $directories = collect();

        foreach ($accounts as $account) {
            $storage = CloudStorage::driver($account->provider);
            $storage->setToken($account->token());

            /*
             * Hiển thị 10 thư mục có thời gian thay đổi gần đây nhất nhưng Dropbox không cung cấp thời gian thay đổi
             * của thư mục nên không thể sắp xếp được
             *
             * FixMe: Tìm cách hiển thị những thư mục có thời gian thay đổi gần đây nhất
             */
            collect($storage->allDirectories())
                ->sortByDesc('timestamp')
                ->take(self::MAX_NUMBER_OF_DIRECTORY - $directories->count())
                ->each(function (array $directory) use ($account, $directories) {
                    $directory['account'] = $account;
                    $directories->add($directory);
                });
        }

        return view('pages.dashboard', compact('directories', 'files'));
    }
}
