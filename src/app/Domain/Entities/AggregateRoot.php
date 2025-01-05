<?php

namespace App\Domain\Entities;

use App\Domain\Events\DomainEvent;

abstract class AggregateRoot
{
    private array $events = [];
    private ?int $id;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    protected function addEvent(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function clearEvents(): void
    {
        $this->events = [];
    }
}
