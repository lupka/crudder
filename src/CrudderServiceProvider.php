<?php

namespace Lupka\Crudder;

use Illuminate\Support\ServiceProvider;

class CrudderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load Views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'crudder');

        // Publish Config
        $this->publishes([
            __DIR__.'/config/crudder.php' => config_path('crudder.php'),
        ], 'config');
    }

    public function register()
    {
        // Bind crudder, used for facade
        $this->app->bind('crudder', 'Lupka\Crudder\Crudder');
    }
}
