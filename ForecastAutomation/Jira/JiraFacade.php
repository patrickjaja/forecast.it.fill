<?php

namespace ForecastAutomation\Jira;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method \ForecastAutomation\Jira\JiraFactory getFactory()
 */
class JiraFacade extends AbstractFacade
{
    public function getJiraActivities(string $startDate): ActivityDtoCollection
    {
        return $this->getFactory()->createJiraCollector()->getJiraActivities($startDate);
    }
}
