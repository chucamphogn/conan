<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\RedirectResponse;

interface HandleRegisterServiceController
{
    public function redirectToLoginPage(): RedirectResponse;

    public function handleCallback(): RedirectResponse;
}
