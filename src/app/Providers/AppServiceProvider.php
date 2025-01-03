<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\IFormEntryRepository;
use App\Infrastructure\Repositories\FormEntry\FormEntryRepository;
use App\Application\Services\FormEntry\FormEntryService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IFormEntryRepository::class, FormEntryRepository::class);

        $this->app->bind(FormEntryService::class, function ($app) {
            return new FormEntryService($app->make(IFormEntryRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
