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
     * Số lượng tệp tin tối đa sẽ hiển thị trên giao diện.
     */
    private const MAX_NUMBER_OF_FILE = 10;

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
     * Trang chủ hiển thị các thư mục, tệp tin được chỉnh sửa gần đây nhất từ các kho lưu trữ.
     *
     * @return View
     */
    public function index(): View
    {
        /** @var Account[] $accounts */
        $accounts = auth()->user()->cloudStorageAccounts()->get();

        // Danh sách thư mục được chỉnh sửa gần đây
        $directories = collect();

        // Danh sách tệp tin được chỉnh sửa gần đây
        $files = collect();

        foreach ($accounts as $account) {
            $storage = CloudStorage::driver($account->provider);
            $storage->setToken($account->token());

            $files->add(
                $storage->recentlyModifiedFiles()->map(function (array $file) use ($account) {
                    $file['account'] = $account;

                    return $file;
                })
            );

            $directories->add(
                $storage->recentlyModifiedDirectories()->map(function (array $directory) use ($account) {
                    $directory['account'] = $account;

                    return $directory;
                })
            );
        }

        // Sau khi đã lấy đủ thư mục, tệp tin từ các kho lưu trữ khác nhau thì sẽ sắp xếp lại lần nữa
        $files = $files->collapse()
            ->sortByDesc('timestamp')
            ->take(self::MAX_NUMBER_OF_FILE)
            ->toArray();

        $directories = $directories->collapse()
            ->sortByDesc('timestamp')
            ->take(self::MAX_NUMBER_OF_DIRECTORY)
            ->toArray();

        return view('pages.dashboard', compact('files', 'directories'));
    }
}
