<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient;

use ForecastAutomation\AmqpClient\Shared\Plugin\AmqpAdapterPluginPlugin;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use ForecastAutomation\QueueClient\Shared\Plugin\AdapterPluginInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Extension\Extension;

class QueueClientDependencyExtension extends Extension
{
    public function createQueueAdapter(): AdapterPluginInterface
    {
        return new AmqpAdapterPluginPlugin();
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $container->set(AmqpAdapterPluginPlugin::class, $this->createQueueAdapter());
        // TODO: Implement load() method.
    }
}
