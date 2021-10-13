<?php

declare(strict_types = 1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity;

use ForecastAutomation\Activity\Business\ActivityCollector;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;
use ForecastAutomation\GitlabClient\Shared\Plugin\GitlabActivityPlugin;
use ForecastAutomation\JiraClient\Shared\Plugin\JiraActivityPlugin;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\HasMessageChannelFilter;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\IsDirectChannelFilter;
use ForecastAutomation\MattermostClient\Shared\Plugin\MattermostActivityPlugin;

class ActivityFactory extends AbstractFactory
{
    //    public function __construct(private ActivityPluginCollection $activityPluginCollection)
    //    {
    //    }
    //

    public function __construct(private ActivityPluginCollection $activityPluginCollection)
    {
    }

    public function createActivityCollector(): ActivityCollector
    {
        return new ActivityCollector($this->activityPluginCollection);
    }
}
