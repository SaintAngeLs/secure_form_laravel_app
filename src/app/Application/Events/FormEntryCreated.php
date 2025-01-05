<?php

namespace App\Application\Events;

use App\Domain\Entities\FormEntry as DomainFormEntry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormEntryCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public DomainFormEntry $formEntry;

    /**
     * Create a new event instance.
     */
    public function __construct(DomainFormEntry $formEntry)
    {
        $this->formEntry = $formEntry;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('form-entries');
    }

    /**
     * The data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'first_name' => $this->formEntry->getFirstName(),
            'last_name' => $this->formEntry->getLastName(),
            'file_id' => $this->formEntry->getFileId(),
        ];
    }
}
