<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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

    public function send(ActivityDtoCollection $activityDtoCollection): int
    {
        return $this->getFactory()->createActivitySendQueueProcess()->send($activityDtoCollection);
    }
}
