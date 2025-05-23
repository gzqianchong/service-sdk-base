<?php

namespace App\Providers;

use App\Console\Commands\CoreFeature;
use App\Console\Commands\CoreUnit;
use App\Console\Commands\MakeController;
use App\Console\Commands\MakeModule;
use App\Console\Commands\MakeSdkService;
use App\Console\Commands\SdkService;
use Illuminate\Support\ServiceProvider;

class ServiceSdkServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CoreUnit::class,
                CoreFeature::class,
                MakeModule::class,
                MakeController::class,
                SdkService::class,
                MakeSdkService::class,
            ]);
        }
    }
}
