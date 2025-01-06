<?php

namespace App\Application\Events;

use App\Application\DTO\FormEntryDTO;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormSubmittedEvent
{
    use Dispatchable, SerializesModels;

    public FormEntryDTO $formEntry;

    /**
     * Create a new event instance.
     *
     * @param FormEntryDTO $formEntry
     */
    public function __construct(FormEntryDTO $formEntry)
    {
        $this->formEntry = $formEntry;
    }

    /**
     * Get the event data.
     *
     * @return array
     */
    public function getEventData(): array
    {
        return [
            'first_name' => $this->formEntry->firstName,
            'last_name' => $this->formEntry->lastName,
            'file_id' => $this->formEntry->fileId,
        ];
    }
}
