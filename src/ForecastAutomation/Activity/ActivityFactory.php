<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity;

use ForecastAutomation\Activity\Business\ActivityCollector;
use ForecastAutomation\Activity\Business\ActivitySendQueueProcess;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;
use ForecastAutomation\ForecastDataImport\ForecastDataImportDependencyProvider;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\QueueClient\QueueClientFacade;

class ActivityFactory extends AbstractFactory
{
    public function getActivityPlugins(): ActivityPluginCollection
    {
        return $this->getProvidedDependency(ActivityDependencyProvider::ACTIVITY_PLUGINS);
    }

    public function createActivityCollector(): ActivityCollector
    {
        return new ActivityCollector($this->getActivityPlugins());
    }

    public function createActivitySendQueueProcess(): ActivitySendQueueProcess
    {
        return new ActivitySendQueueProcess(
            $this->getQueueClientFacade(),
        );
    }

    public function getQueueClientFacade(): QueueClientFacade
    {
        return $this->getProvidedDependency(ActivityDependencyProvider::QUEUE_CLIENT_FACADE);
    }
}
