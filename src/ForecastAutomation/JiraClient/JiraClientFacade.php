<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
