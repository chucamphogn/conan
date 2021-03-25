<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Facades\App\Manager\CloudStorage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Đổi tên tệp tin, thư mục.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function rename(Request $request): JsonResponse
    {
        /** @var string $email */
        $email = $request->input('email');

        /** @var string $provider */
        $provider = $request->input('provider');

        // Xác định kho lưu trữ và lấy token của tài khoản để thao tác
        $storage = CloudStorage::driver($provider);
        $storage->setToken(auth()->user()->getTokenOf($email, $provider));

        /*
         * Giả sử muốn đổi tên tệp tin c thành f, ta có đường dẫn của tệp tin c là: a/b/c
         * Trong đó: a, b là thư mục và c là tệp tin (chuỗi c có thể đã bị mã hóa hoặc vẫn giữ nguyên tên tùy kho lưu trữ)
         * Replace c thành f ta được a/b/f là được đường dẫn mới với tên tệp tin đã thay đổi
         */
        $currentPath = $request->input('path');

        $newPath = explode('/', $currentPath);
        $newPath[count($newPath) - 1] = $request->input('name');
        $newPath = join('/', $newPath);

        try {
            $storage->rename($currentPath, $newPath);

            return response()->json([
                'message' => 'Đổi tên thành công',
            ]);
        } catch (FileExistsException $e) {
            return response()->json([
                'message' => 'Tệp tin đã tồn tại, vui lòng đổi tên khác.',
            ], Response::HTTP_CONFLICT);
        } catch (FileNotFoundException $e) {
            return response()->json([
                'message' => 'Không tìm thấy tệp tin cần đổi tên.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Tải xuống tệp tin, không tải được thư mục.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account      $account
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Request $request, Account $account): StreamedResponse
    {
        /** @var string $path */
        $path = $request->input('path');

        /** @var string $basename */
        $basename = $request->input('basename');

        $storage = CloudStorage::driver($account->provider);
        $storage->setToken($account->token());

        return $storage->download($path, $basename);
    }
}
