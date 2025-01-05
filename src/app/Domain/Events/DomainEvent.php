<?php

namespace App\Domain\Events;

interface DomainEvent
{
    public function occurredOn(): \DateTimeImmutable;
}
