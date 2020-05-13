<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
       Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDevProviders();
    }

    private function registerDevProviders()
    {
        if ($this->app->environment() === 'production') return;

        if ($this->ideHelperExists()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    private function ideHelperExists()
    {
        return class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }
}
