<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ProjektronClient;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method \ForecastAutomation\JiraClient\JiraClientFactory getFactory()
 */
class ProjektronClientFacade extends AbstractFacade
{
    public function writeActivities(ActivityDtoCollection $activityDtoCollection): int
    {
        https://projektron.valantic.com/bcs/login
        $test = $activityDtoCollection;
        return 10;
    }
}
