<?php

namespace Lupka\Crudder;

use Illuminate\Support\ServiceProvider;

class CrudderServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('crudder', 'Lupka\Crudder\Crudder');
    }
}
