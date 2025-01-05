<?php

namespace App\Providers;

use App\Application\Services\Files\FileService;
use App\Application\Services\Files\FileValidationService;
use App\Domain\Repositories\IFileRepository;
use App\Infrastructure\Repositories\Files\FileRepository;
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

        $this->app->bind(IFileRepository::class, FileRepository::class);

        $this->app->bind(FormEntryService::class, function ($app) {
            return new FormEntryService($app->make(IFormEntryRepository::class));
        });

        $this->app->singleton(FileValidationService::class, function ($app) {
            return new FileValidationService();
        });

        $this->app->bind(FileService::class, function ($app) {
            return new FileService(
                $app->make(IFileRepository::class),
                $app->make(FileValidationService::class)
            );
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
