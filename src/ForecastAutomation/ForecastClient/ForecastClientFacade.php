<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastClient;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method \ForecastAutomation\ForecastClient\ForecastClientFactory getFactory()
 */
class ForecastClientFacade extends AbstractFacade
{
    public function writeActivities(ActivityDtoCollection $activityDtoCollection): int
    {
        return $this->getFactory()->createForecastApi()->writeActivities($activityDtoCollection);
    }
}
