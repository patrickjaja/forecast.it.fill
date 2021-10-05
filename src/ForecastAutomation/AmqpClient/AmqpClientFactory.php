<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\AmqpClient;

use Enqueue\AmqpExt\AmqpConnectionFactory;
use Enqueue\AmqpExt\AmqpContext;
use ForecastAutomation\AmqpClient\Business\Consumer;
use ForecastAutomation\AmqpClient\Business\Producer;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\QueueClient\Shared\Plugin\QueuePluginCollection;
use ForecastAutomation\Serializer\SerializerFacade;

class AmqpClientFactory extends AbstractFactory
{
    public function createConsumer(): Consumer
    {
        return new Consumer(
            $this->createAmqpContext(),
            $this->getQueuePluginCollection(),
            $this->getSerializerFacade(),
            $this->getLogFacade(),
        );
    }

    public function createProducer(): Producer
    {
        return new Producer(
            $this->createAmqpContext(),
            $this->getQueuePluginCollection(),
            $this->getSerializerFacade(),
            $this->getLogFacade(),
        );
    }

    public function createAmqpContext(): AmqpContext
    {
        return (new AmqpConnectionFactory(
            [
                'host' => $_ENV['AMQP_HOST'],
                'port' => (int) $_ENV['AMQP_PORT'],
                'vhost' => $_ENV['AMQP_VHOST'],
                'user' => $_ENV['AMQP_USER'],
                'pass' => $_ENV['AMQP_PASS'],
                'persisted' => false,
            ]
        ))->createContext();
    }

    public function getSerializerFacade(): SerializerFacade
    {
        return $this->getProvidedDependency(AmqpClientDependencyProvider::SERIALIZER_FACADE);
    }

    public function getQueuePluginCollection(): QueuePluginCollection
    {
        return $this->getProvidedDependency(AmqpClientDependencyProvider::QUEUE_PLUGIN_COLLECTION);
    }

    public function getLogFacade(): LogFacade
    {
        return $this->getProvidedDependency(AmqpClientDependencyProvider::LOG_FACADE);
    }
}
