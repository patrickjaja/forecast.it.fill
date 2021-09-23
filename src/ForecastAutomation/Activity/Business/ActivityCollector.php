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
use GuzzleHttp\Promise\Utils;

class ActivityCollector
{
    public function __construct(private ActivityPluginCollection $activityPluginCollection)
    {
    }

    public function collect(): ActivityDtoCollection
    {
        $activityDtoCollections = Utils::all($this->activityPluginCollection->collect())->wait();

        return $this->mergeActivityDtoCollections($activityDtoCollections);
    }

    private function mergeActivityDtoCollections(array $activityDtoCollections): ActivityDtoCollection
    {
        $mergedActivityDtoCollection = new ActivityDtoCollection();
        foreach ($activityDtoCollections as $activityDtoCollection) {
            $mergedActivityDtoCollection->merge($activityDtoCollection);
        }

        return $mergedActivityDtoCollection;
    }
}
