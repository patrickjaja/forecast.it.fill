<?php

namespace ForecastAutomation\Jira\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;

/**
 * @method \ForecastAutomation\Jira\JiraFacade getFacade()
 */
class JiraActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    public function collect(): ActivityDtoCollection
    {
        return $this->getFacade()->getJiraActivities(date('Y-m-d 00:00'));
    }
}
