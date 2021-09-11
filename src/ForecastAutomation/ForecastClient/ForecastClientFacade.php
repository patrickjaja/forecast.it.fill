<?php

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
