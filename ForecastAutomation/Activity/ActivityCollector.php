<?php

namespace ForecastAutomation\Activity;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;

class ActivityCollector
{
    public function __construct(private ActivityPluginCollection $activityPluginCollection) { }

    public function collect(): ActivityDtoCollection {
        $activityDtoCollection = new ActivityDtoCollection();
        foreach ($this->activityPluginCollection as $activityPlugin) {
            $activityDtoCollection = $activityDtoCollection->merge($activityPlugin->collect());
        }
        return $activityDtoCollection;
    }
}
