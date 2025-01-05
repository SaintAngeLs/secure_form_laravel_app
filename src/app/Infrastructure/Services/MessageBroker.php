<?php

namespace App\Infrastructure\Services;

use App\Application\Services\Infrastructure\IMessageBroker;
use RdKafka\Consumer;
use RdKafka\Producer;

class MessageBroker implements IMessageBroker
{
    private Producer $producer;
    private Consumer $consumer;

    public function __construct(string $brokers)
    {
        $this->producer = new Producer();
        $this->producer->addBrokers($brokers);

        $conf = new \RdKafka\Conf();
        $conf->set('metadata.broker.list', $brokers);
        $this->consumer = new Consumer($conf);
    }

    public function publishAsync(string $topic, string $message): void
    {
        $kafkaTopic = $this->producer->newTopic($topic);
        $kafkaTopic->produce(RD_KAFKA_PARTITION_UA, 0, $message);

        // Wait for the message to be sent.
        $this->producer->flush(1000);
    }

    public function subscribeAsync(string $topic, callable $callback): void
    {
        $kafkaTopic = $this->consumer->newTopic($topic);
        $kafkaTopic->consumeStart(0, RD_KAFKA_OFFSET_END);

        while (true) {
            $message = $kafkaTopic->consume(0, 1000);

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $callback($message->payload);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    // Handle EOF or timeout gracefully.
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
            }
        }
    }
}
