<?php

namespace App\Application\Events;

use App\Infrastructure\Persistence\Models\FormEntry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormEntryCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public FormEntry $formEntry;

    /**
     * Create a new event instance.
     */
    public function __construct(FormEntry $formEntry)
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
            'id' => $this->formEntry->id,
            'first_name' => $this->formEntry->first_name,
            'last_name' => $this->formEntry->last_name,
            'file' => $this->formEntry->file ? [
                'id' => $this->formEntry->file->id,
                'name' => $this->formEntry->file->name,
                'path' => $this->formEntry->file->path,
            ] : null,
            'created_at' => $this->formEntry->created_at->toDateTimeString(),
        ];
    }
}
