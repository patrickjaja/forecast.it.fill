<?php

namespace ForecastAutomation\Activity;

use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;
use ForecastAutomation\Jira\Shared\Plugin\JiraActivityPlugin;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;

class ActivityDependencyProvider extends AbstractDependencyProvider
{
    public const ACTIVITY_PLUGINS = 'ACTIVITY_PLUGINS';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::ACTIVITY_PLUGINS, $this->getActivityPlugins());
    }

    public function getActivityPlugins(): ActivityPluginCollection
    {
        return (new ActivityPluginCollection(new JiraActivityPlugin()));
    }
}
