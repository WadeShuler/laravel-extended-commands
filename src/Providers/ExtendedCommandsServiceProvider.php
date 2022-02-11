<?php

namespace WadeShuler\ExtendedCommands\Providers;

use Illuminate\Support\ServiceProvider;
use WadeShuler\ExtendedCommands\Console\Commands\ClearLogs;
use WadeShuler\ExtendedCommands\Console\Commands\MakeAction;
use WadeShuler\ExtendedCommands\Console\Commands\MakeContract;
use WadeShuler\ExtendedCommands\Console\Commands\MakeEnum;
use WadeShuler\ExtendedCommands\Console\Commands\MakeService;
use WadeShuler\ExtendedCommands\Console\Commands\MakeTrait;

class ExtendedCommandsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearLogs::class,
                MakeAction::class,
                MakeContract::class,
                MakeEnum::class,
                MakeService::class,
                MakeTrait::class,
            ]);
        }
    }
}
