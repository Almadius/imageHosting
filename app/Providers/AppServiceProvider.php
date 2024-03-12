<?php

namespace App\Providers;

use App\Contracts\ImageRepositoryInterface;
use App\Repositories\EloquentImageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImageRepositoryInterface::class, EloquentImageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
