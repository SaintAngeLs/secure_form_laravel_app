<?php

namespace App\Infrastructure\Services;

use App\Application\Services\Infrastructure\IMessageBroker;
use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use Illuminate\Support\Facades\Log;

class MessageBroker implements IMessageBroker
{
    private Producer $producer;
    private KafkaConsumer $consumer;

    public function __construct(string $brokers, string $consumerGroup = 'default-consumer-group')
    {
        if (empty($brokers)) {
            throw new \InvalidArgumentException("Bootstrap servers must be configured.");
        }

        $conf = new \RdKafka\Conf();
        $conf->set('metadata.broker.list', $brokers);

        $conf->set('bootstrap.servers', $brokers);



        $this->producer = new Producer($conf);
        $conf->set('group.id', $consumerGroup);
        $conf->set('auto.offset.reset', 'earliest');
        $conf->set('enable.auto.commit', 'true');
        $this->producer->addBrokers($brokers);

        $this->consumer = new KafkaConsumer($conf);
    }

    public function publishAsync(string $topic, string $message): void
    {
        $kafkaTopic = $this->producer->newTopic($topic);
        $kafkaTopic->produce(RD_KAFKA_PARTITION_UA, 0, $message);

        $this->producer->flush(100);
    }

    public function subscribeAsync(string $topic, callable $callback): void
    {
        // $kafkaTopic = $this->consumer->newTopic($topic);
        $this->consumer->subscribe([$topic]);
        // $kafkaTopic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

        while (true) {
            // $message = $kafkaTopic->consume(0, 1000);
            $message = $this->consumer->consume(1000);

            if (is_null($message)) {
                Log::warning("Kafka consume returned null message.");
                continue;
            }

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    Log::info("Kafka message received: " . $message->payload);
                    $callback($message->payload);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    Log::warning("Kafka partition EOF reached.");
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    Log::warning("Kafka consume timed out.");
                    break;
                default:
                    Log::error("Kafka error: " . $message->errstr());
                    throw new \Exception($message->errstr(), $message->err);
            }
        }
    }

}
