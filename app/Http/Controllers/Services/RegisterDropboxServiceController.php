<?php

namespace App\Http\Controllers\Services;

use App\Enums\Provider;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Dropbox\Provider as DropboxProvider;

class RegisterDropboxServiceController extends Controller implements HandleRegisterServiceController
{
    private DropboxProvider $dropboxProvider;

    public function __construct()
    {
        $this->dropboxProvider = Socialite::driver('dropbox');
    }

    public function redirectToLoginPage(): RedirectResponse
    {
        return $this->dropboxProvider
            ->scopes(['files.metadata.write', 'files.metadata.read', 'files.content.write', 'files.content.read'])
            ->with([
                'token_access_type' => 'offline',
            ])
            ->redirect();
    }

    public function handleCallback(): RedirectResponse
    {
        $user = $this->dropboxProvider->user();

        auth()->user()->cloudStorage()->create([
            'user_id' => auth()->id(),
            'alias_name' => $user->getName(),
            'email' => $user->getEmail(),
            'provider' => Provider::DROPBOX(),
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken,
            'expires_in' => $user->expiresIn,
        ]);

        return redirect()->route('dashboard');
    }
}
