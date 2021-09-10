<?php

namespace ForecastAutomation\JiraClient;

use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method \ForecastAutomation\JiraClient\JiraClientFactory getFactory()
 */
class JiraClientFacade extends AbstractFacade
{
    public function getComments(string $startDate): array
    {
        return $this->getFactory()->createJiraCollector()->getComments($startDate);
    }
}
