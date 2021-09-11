<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity;

use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;
use ForecastAutomation\Kernel\AbstractFactory;

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
}
