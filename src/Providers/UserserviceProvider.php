<?php

namespace Oishin\Userservice\Providers;

use Illuminate\Support\ServiceProvider;

class UserserviceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
