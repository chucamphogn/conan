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

    public function redirectProviderLogin(): RedirectResponse
    {
        return $this->dropboxProvider
            ->scopes(['files.metadata.write', 'files.metadata.read', 'files.content.write', 'files.content.read'])
            ->with([
                'token_access_type' => 'offline',
            ])
            ->redirect();
    }

    public function handleProviderCallback(): RedirectResponse
    {
        $userSocialite = $this->dropboxProvider->user();

        auth()->user()->addCloudStorageAccount($userSocialite, Provider::DROPBOX());

        return redirect()->route('dashboard');
    }
}
