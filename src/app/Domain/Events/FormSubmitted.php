<?php

namespace App\Domain\Events;

use App\Domain\Entities\FormEntry;

class FormSubmitted implements DomainEvent
{
    private FormEntry $formEntry;
    private \DateTimeImmutable $occurredOn;

    public function __construct(FormEntry $formEntry)
    {
        $this->formEntry = $formEntry;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function getFormEntry(): FormEntry
    {
        return $this->formEntry;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
