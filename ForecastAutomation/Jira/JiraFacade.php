<?php

namespace ForecastAutomation\Jira;

use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method \ForecastAutomation\Jira\JiraFactory getFactory()
 */
class JiraFacade extends AbstractFacade
{
    public function getComments(string $startDate): array
    {
        return $this->getFactory()->createJiraCollector()->getComments($startDate);
    }
}
