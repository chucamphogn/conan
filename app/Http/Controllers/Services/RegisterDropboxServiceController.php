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

    private array $scopes = [
        'files.metadata.write',
        'files.metadata.read',
        'files.content.write',
        'files.content.read',
    ];

    private array $with = [
        'token_access_type' => 'offline',
    ];

    public function __construct()
    {
        $this->dropboxProvider = Socialite::driver(Provider::DROPBOX()->getValue());
    }

    public function redirectProviderLogin(): RedirectResponse
    {
        return $this->dropboxProvider
            ->scopes($this->scopes)
            ->with($this->with)
            ->redirect();
    }

    public function handleProviderCallback(): RedirectResponse
    {
        $userSocialite = $this->dropboxProvider->user();

        auth()->user()->addCloudStorageAccount($userSocialite, Provider::DROPBOX());

        return redirect()->route('dashboard');
    }
}
