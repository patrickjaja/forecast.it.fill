<?php

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
