<?php

namespace Douma\ControllerPlugins;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('controller_plugins.php'),
        ]);
    }
}
