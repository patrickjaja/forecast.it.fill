<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity\Business;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;

class ActivityCollector
{
    public function __construct(private ActivityPluginCollection $activityPluginCollection)
    {
    }

    public function collect(): ActivityDtoCollection
    {
        $activityDtoCollection = new ActivityDtoCollection();
        foreach ($this->activityPluginCollection as $activityPlugin) {
            $activityDtoCollection = $activityDtoCollection->merge($activityPlugin->collect());
        }

        return $activityDtoCollection;
    }
}