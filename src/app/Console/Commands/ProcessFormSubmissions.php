<?php

namespace App\Console\Commands;

use App\Infrastructure\Services\FormSubmissionsProcessor;
use Illuminate\Console\Command;

class ProcessFormSubmissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-form-submissions-processor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process form submissions from the Kafka topic';

    private FormSubmissionsProcessor $processor;

    public function __construct(FormSubmissionsProcessor $processor)
    {
        parent::__construct();
        $this->processor = $processor;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting FormSubmissionsProcessor...');
        $this->processor->handleFormSubmissions();
    }
}
