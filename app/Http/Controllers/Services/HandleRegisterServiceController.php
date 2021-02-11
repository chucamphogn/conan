<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\RedirectResponse;

interface HandleRegisterServiceController
{
    public function redirectProviderLogin(): RedirectResponse;

    public function handleProviderCallback(): RedirectResponse;
}
