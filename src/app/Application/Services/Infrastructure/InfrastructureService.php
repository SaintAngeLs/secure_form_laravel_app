<?php

namespace App\Application\Services\Infrastructure;

use Illuminate\Support\Facades\Log;

class InfrastructureService
{
    /**
     * Check if Kafka is available.
     *
     * @return bool
     */
    public function isKafkaAvailable(): bool
    {
        $kafkaBrokers = config('app.kafka_brokers', '');
        return !empty($kafkaBrokers) && $this->canConnectToService($kafkaBrokers, 9092);
    }

    /**
     * Check if Redis is available.
     *
     * @return bool
     */
    public function isRedisAvailable(): bool
    {
        try {
            return app('redis')->ping() === '+PONG';
        } catch (\Exception $e) {
            Log::warning('Redis connection failed.', ['exception' => $e]);
            return false;
        }
    }

    /**
     * Generic function to check service connectivity.
     *
     * @param string $host
     * @param int $port
     * @return bool
     */
    private function canConnectToService(string $host, int $port): bool
    {
        $fp = @fsockopen($host, $port, $errno, $errstr, 2);
        if ($fp) {
            fclose($fp);
            return true;
        }
        Log::warning("Service at $host:$port is not available. Error: $errstr");
        return false;
    }
}
