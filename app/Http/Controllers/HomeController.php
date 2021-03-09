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
     * @return View
     */
    public function index(): View
    {
        /** @var Account[] $accounts */
        $accounts = auth()->user()->cloudStorageAccounts()->get();

        $directories = collect();
        $files = collect();

        foreach ($accounts as $account) {
            $storage = CloudStorage::driver($account->provider);
            $storage->setToken($account->token());

            // FixMe: Chưa tối ưu vì tốn rất nhiều request để lấy thông tin "Thời gian sửa đổi" của thư mục
            foreach ($storage->allDirectories(recursive: false) as $directory) {
                /*
                 * Nếu thư mục không được cung cấp "Thời gian sửa đổi" thì sẽ lấy thời gian của các tệp tin của
                 * thư mục đó làm "Thời gian sửa đổi" cho thư mục
                 */
                if (!isset($directory['timestamp'])) {
                    $lastModified = collect($storage->listContents($directory['path'], true))->max('timestamp');
                    $directory['timestamp'] = $lastModified;
                }

                // Gán tài khoản kho lưu trữ để phân biệt
                $directory['account'] = $account;

                $directories->add($directory);
            }
        }

        // Sau khi đã có đủ 10 thư mục từ các kho lưu trữ khác nhau thì sẽ sắp xếp lại lần nữa
        $directories = $directories->sortByDesc('timestamp')->take(self::MAX_NUMBER_OF_DIRECTORY);

        return view('pages.dashboard', compact('directories', 'files'));
    }
}
