<?php

namespace App\Providers;

use App\Application\Services\Files\FileService;
use App\Application\Services\Files\FileValidationService;
use App\Application\Services\Infrastructure\IMessageBroker;
use App\Application\Services\Infrastructure\InfrastructureService;
use App\Domain\Repositories\IFileRepository;
use App\Infrastructure\Services\MessageBroker;
use App\Infrastructure\Repositories\Files\FileRepository;
use App\Infrastructure\Services\UnusedFilesCleaner;
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

        // $this->app->bind(IMessageBroker::class, MessageBroker::class);

        $this->app->singleton(IMessageBroker::class, function ($app) {
            return new MessageBroker(env('KAFKA_BROKERS', 'kafka:9092'));
        });

        $this->app->bind(FormEntryService::class, function ($app) {
            return new FormEntryService(
                $app->make(IFormEntryRepository::class),
                $app->make(IMessageBroker::class),
                $app->make(FileService::class),
            );
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

        $this->app->singleton(UnusedFilesCleaner::class, function ($app) {
            return new UnusedFilesCleaner(
                $app->make(IMessageBroker::class)
            );
        });

        if ($this->app->isLocal()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
