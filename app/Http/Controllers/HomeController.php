<?php

namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    private Google_Client $googleClient;

    public function __construct(Google_Client $googleClient)
    {
        $this->googleClient = $googleClient;
    }

    public function index(): View
    {
        return view('dashboard');
    }

    /**
     * @note Mới chỉ làm sương sương cho nó hiện ra coi chơi thôi
     * @return View
     */
//    public function index(): View
//    {
//        // Lấy danh sách các token từ tài khoản đang đăng nhập
//        $tokens = auth()->user()->cloudStorage()->get();
//
//        $tokens->each(function (Account $token) {
//            // Lấy thông tin tài khoản google drive từ access_token
//            $user = Socialite::driver($token->token_type->value)->userFromToken($token->access_token);
//            echo "<h1>Thông tin từ tài khoản {$user->getEmail()}</h1>";
//
//            // Gán thông tin token vào Google Client bao gồm access_token, refresh_token, expires_in
//            $this->googleClient->setAccessToken($token->toJson());
//
//            // Nếu mã hết hạn thì tiến hành refresh token, nếu không có refresh token thì bắt người ta login lại
//            if ($this->googleClient->isAccessTokenExpired()) {
//                if ($this->googleClient->getRefreshToken()) {
//                    $this->googleClient->fetchAccessTokenWithRefreshToken($this->googleClient->getRefreshToken());
//                } else {
//                    return redirect()->route('account.add-account-google');
//                }
//            }
//
//            $googleServiceDrive = new Google_Service_Drive($this->googleClient);
//
//            $files = $googleServiceDrive->files->listFiles([
//                'pageSize' => 10,
//                'fields' => 'nextPageToken, files',
//            ])->getFiles();
//
//            // Show coi cho vui
//            foreach ($files as $file) {
//                $isFolder = $file->getMimeType() === "application/vnd.google-apps.folder" ?
//                    "<b>(Thư mục)</b>" : '';
//                $text = $file->trashed ? '<b>(Trong thùng rác)</b>' : '';
//                echo "{$file->getName()} ({$file->getId()}) $isFolder $text<br>";
//            }
//
//            echo "<br>";
//
//            // Clear cache để reset lại token được gán trong GoogleClient
//            $this->googleClient->getCache()->clear();
//        });
//
//        return view('dashboard');
//    }
}
