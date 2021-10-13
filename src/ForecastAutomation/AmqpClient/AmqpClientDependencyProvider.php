<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\AmqpClient;

use ForecastAutomation\ForecastClient\Shared\Plugin\ForecastClientQueuePluginPlugin;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\QueueClient\Shared\Plugin\QueuePluginCollection;
use ForecastAutomation\Serializer\SerializerFacade;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AmqpClientDependencyProvider extends AbstractDependencyProvider
{
    // yay librabbitmq
    // sudo pecl install amqp-1.11.0beta
    public const SERIALIZER_FACADE = 'SERIALIZER_FACADE';
    public const LOG_FACADE = 'LOG_FACADE';
    public const QUEUE_PLUGIN_COLLECTION = 'QUEUE_CONSUMER_PLUGINS';

    public function provideDependencies(ContainerInterface $container): void
    {
        $this->set(self::SERIALIZER_FACADE, new SerializerFacade());
        $this->set(self::LOG_FACADE, new LogFacade());
        $this->set(self::QUEUE_PLUGIN_COLLECTION, $this->createQueuePluginCollection());
    }

    protected function createQueuePluginCollection(): QueuePluginCollection
    {
        return new QueuePluginCollection(
            new ForecastClientQueuePluginPlugin(),
        );
    }
}
