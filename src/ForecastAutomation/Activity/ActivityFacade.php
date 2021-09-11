<?php

namespace ForecastAutomation\Activity;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method ActivityFactory getFactory()
 */
class ActivityFacade extends AbstractFacade
{
    public function collect(): ActivityDtoCollection
    {
        return $this->getFactory()->createActivityCollector()->collect();
    }
}
