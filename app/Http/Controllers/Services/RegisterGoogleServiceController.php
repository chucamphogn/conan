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

    public function __construct()
    {
        $this->googleProvider = Socialite::driver('google');
    }

    public function redirectToLoginPage(): RedirectResponse
    {
        return $this->googleProvider
            ->scopes(Google_Service_Drive::DRIVE)
            ->with([
                'access_type' => 'offline',
                'prompt' => 'select_account consent',
            ])
            ->redirect();
    }

    public function handleCallback(): RedirectResponse
    {
        $user = $this->googleProvider->user();

        auth()->user()->cloudStorage()->create([
            'user_id' => auth()->id(),
            'alias_name' => $user->getName(),
            'email' => $user->getEmail(),
            'provider' => Provider::GOOGLE(),
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken,
            'expires_in' => $user->expiresIn,
        ]);

        return redirect()->route('dashboard');
    }
}
