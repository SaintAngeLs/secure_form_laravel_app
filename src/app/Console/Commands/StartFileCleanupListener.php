<?php

namespace App\Console\Commands;

use App\Infrastructure\Services\UnusedFilesCleaner;
use Illuminate\Console\Command;

class StartFileCleanupListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-file-cleanup-listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the unused file cleanup listener to handle unused files events.';

    /**
     * The unused files cleaner service.
     */
    private UnusedFilesCleaner $unusedFilesCleaner;

    /**
     * Create a new command instance.
     *
     * @param UnusedFilesCleaner $unusedFilesCleaner
     */
    public function __construct(UnusedFilesCleaner $unusedFilesCleaner)
    {
        parent::__construct();
        $this->unusedFilesCleaner = $unusedFilesCleaner;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting the unused file cleanup listener...');

        try {
            // Call the handleUnusedFiles method to start the listener
            $this->unusedFilesCleaner->handleUnusedFiles();
        } catch (\Exception $e) {
            $this->error('An error occurred while running the unused file cleanup listener.');
            $this->error($e->getMessage());
        }
    }
}
