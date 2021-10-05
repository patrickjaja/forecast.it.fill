<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\AmqpClient\Business;

use DateTimeImmutable;
use Enqueue\AmqpExt\AmqpContext;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Plugin\QueuePluginCollection;
use ForecastAutomation\Serializer\SerializerFacade;
use Monolog\Processor\UidProcessor;

class Producer
{
    public function __construct(
        private AmqpContext $context,
        private QueuePluginCollection $queuePluginCollection,
        private SerializerFacade $serializerFacade,
        private LogFacade $logFacade
    ) {
    }

    public function sendMessages(string $queueName, MessageCollectionDto $messageCollectionDto): void
    {
        $queue = $this->context->createQueue($this->queuePluginCollection->offsetGet($queueName)->getQueueName());
        $this->context->declareQueue($queue);

        foreach ($messageCollectionDto->messageDtos as $messageDto) {
            $messageDto
                ->setId((new UidProcessor(32))->getUid())
                ->setTime((new DateTimeImmutable())->getTimestamp())
                ->setQueueName($queueName)
            ;
            $msg = $this->serializerFacade->serialize($messageDto);
            $message = $this->context->createMessage($msg);
            $this->logFacade->info('Publishing AMQP Message.', ['queue_message' => $msg]);
            $this->context->createProducer()->send($queue, $message);
        }
    }
}
