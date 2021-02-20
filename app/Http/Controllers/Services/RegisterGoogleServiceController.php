<?php

namespace App\Http\Controllers\Services;

use App\Enums\Provider;
use App\Http\Controllers\Controller;
use Google_Service_Drive;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class RegisterGoogleServiceController extends Controller implements HandleRegisterServiceController
{
    private GoogleProvider $googleProvider;

    private array $scopes = [
        Google_Service_Drive::DRIVE,
    ];

    private array $with = [
        'access_type' => 'offline',
        'prompt' => 'select_account consent',
    ];

    public function __construct()
    {
        $this->googleProvider = Socialite::driver(Provider::GOOGLE()->getValue());
    }

    public function redirectProviderLogin(): RedirectResponse
    {
        return $this->googleProvider
            ->scopes($this->scopes)
            ->with($this->with)
            ->redirect();
    }

    public function handleProviderCallback(): RedirectResponse
    {
        $userSocialite = $this->googleProvider->user();

        auth()->user()->addCloudStorageAccount($userSocialite, Provider::GOOGLE());

        return redirect()->route('dashboard');
    }
}
