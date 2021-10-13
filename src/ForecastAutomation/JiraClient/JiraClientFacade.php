<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\JiraClient;

use ForecastAutomation\Kernel\AbstractFacade;

class JiraClientFacade extends AbstractFacade
{
    public function __construct(private JiraClientFactory $jiraClientFactory)
    {
    }

    public function getComments(string $startDate): array
    {
        return $this->jiraClientFactory->createJiraCollector()->getComments($startDate);
    }
}
