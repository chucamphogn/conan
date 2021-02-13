<?php

namespace App\Providers;

use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ViewFactory::composer('layouts.navigation', function (View $view) {
            $cloudStorageAccounts = auth()->user()
                ->cloudStorageAccounts()
                ->oldest('alias_name')
                ->get();
            $view->with('cloudStorageAccounts', $cloudStorageAccounts);
        });
    }

    public function register()
    {
    }
}
