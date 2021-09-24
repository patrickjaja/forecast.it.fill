<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity;

use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;
use ForecastAutomation\GitlabClient\Shared\Plugin\GitlabActivityPlugin;
use ForecastAutomation\JiraClient\Shared\Plugin\JiraActivityPlugin;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\HasMessageChannelFilter;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\IsDirectChannelFilter;
use ForecastAutomation\MattermostClient\Shared\Plugin\MattermostActivityPlugin;

class ActivityDependencyProvider extends AbstractDependencyProvider
{
    public const ACTIVITY_PLUGINS = 'ACTIVITY_PLUGINS';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::ACTIVITY_PLUGINS, $this->getActivityPlugins());
    }

    public function getActivityPlugins(): ActivityPluginCollection
    {
        return new ActivityPluginCollection(
            new JiraActivityPlugin(),
            new MattermostActivityPlugin(
                new HasMessageChannelFilter(new \DateTime(date('Y-m-d'))),
                new IsDirectChannelFilter(),
            ),
            new GitlabActivityPlugin(),
        )

        ;
    }
}
