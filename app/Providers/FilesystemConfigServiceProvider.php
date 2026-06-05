<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

class FilesystemConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Untuk hosting yang tidak support symlink, gunakan URL ke public disk secara langsung
        if (env('APP_ENV') === 'production' && env('NO_SYMLINK', false)) {
            // Override storage URL generator
            $this->app['url']->defaults['diskUrl'] = function () {
                return rtrim(config('app.url'), '/') . '/storage';
            };
        }
    }
}
