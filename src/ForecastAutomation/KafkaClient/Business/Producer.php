<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\KafkaClient\Business;

use DateTimeImmutable;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\Serializer\SerializerFacade;
use Monolog\Processor\UidProcessor;
use RdKafka\Conf;

class Producer
{
    public function __construct(
        private Conf $conf,
        private SerializerFacade $serializerFacade,
        private LogFacade $logFacade
    ) {
    }

    public function sendMessages(string $queueName, MessageCollectionDto $messageCollectionDto)
    {
        $producer = new \RdKafka\Producer($this->conf);

        $topic = $producer->newTopic($queueName);

        foreach ($messageCollectionDto->messageDtos as $messageDto) {
            $messageDto->id = (new UidProcessor(32))->getUid();
            $messageDto->time = (new DateTimeImmutable())->getTimestamp();
            $msg = $this->serializerFacade->serialize($messageDto);
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $msg);
            $producer->poll(0);
            $this->logFacade->info('Publishing Kafka Message.', ['queue_message' => $msg]);
        }

        for ($flushRetries = 0; $flushRetries < 10; ++$flushRetries) {
            $result = $producer->flush(10000);
            if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
                break;
            }
        }

        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
            throw new \RuntimeException('Was unable to flush, messages might be lost!');
        }
    }
}
