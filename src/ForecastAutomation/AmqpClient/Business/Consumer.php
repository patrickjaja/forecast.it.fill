<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\AmqpClient\Business;

use Enqueue\AmqpExt\AmqpContext;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageDto;
use ForecastAutomation\QueueClient\Shared\Plugin\QueuePluginCollection;
use ForecastAutomation\Serializer\SerializerFacade;

class Consumer
{
    public function __construct(
        private AmqpContext $context,
        private QueuePluginCollection $queuePluginCollection,
        private SerializerFacade $serializerFacade,
        private LogFacade $logFacade
    ) {
    }

    public function consume(string $queueName): void
    {
        // https://blog.forma-pro.com/getting-started-with-rabbitmq-in-php-84d331e20a66
        $queue = $this->context->createQueue($this->queuePluginCollection->offsetGet($queueName)->getQueueName());
        $this->context->declareQueue($queue);

        $consumer = $this->context->createConsumer($queue);

        $totalMessages = 0;
        $maxMessages = 5000;
        while ($totalMessages < $maxMessages) {
            $message = $consumer->receive($timeout = 10);

            if (null === $message) {
                break;
            }
            $this->logFacade->info('Got AMQP Raw Message.', ['amqp_message' => $message]);
            $messageDto = (new MessageDto(...$this->serializerFacade->deserialize($message->getBody())));
            $messageDto->setAdapterMetaResponse(['properties' => $message->getProperties(), 'headers' => $message->getHeaders(), 'deliveryTag' => $message->getDeliveryTag(), 'consumerTag' => $message->getConsumerTag(), 'redelivered' => $message->isRedelivered(), 'flags' => $message->getFlags(), 'routingKey' => $message->getRoutingKey()]);

            $messageConsumed = $this->queuePluginCollection->offsetGet($queueName)->consumeMessage(
                $messageDto
            );

            if ($messageConsumed) {
                $consumer->acknowledge($message);
            }

            ++$totalMessages;
        }
    }
}
