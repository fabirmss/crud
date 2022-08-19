<?php

namespace App\Providers\ViewComposer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

/**
 * Class ComposerServiceProvider
 *
 * @package App\Providers\ViewComposer
 *
 * @author Lucas Bernieri Ramos
 * @since 1.0.0
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     *
     * @author Lucas Bernieri Ramos
     * @since 1.0.0
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with('authUser', Auth::user());
        });
    }
}
