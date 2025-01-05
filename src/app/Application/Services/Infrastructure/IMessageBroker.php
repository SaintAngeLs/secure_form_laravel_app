<?php

namespace App\Application\Services\Infrastructure;

interface IMessageBroker
{
    public function publishAsync(string $topic, string $message): void;
    public function subscribeAsync(string $topic, callable $callback): void;
}
