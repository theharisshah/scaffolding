<?php

namespace DeepSpace9\Scaffolding;

use Illuminate\Support\ServiceProvider;

/**
 * Class ScaffoldingServiceProvider
 * @package DeepSpace9\Scaffolding
 */
class ScaffoldingServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BaseServiceMakeCommand::class,
                ServiceMakeCommand::class,
                ServiceControllerMakeCommand::class,
                ServiceExceptionMakeCommand::class
            ]);
        }
    }

}