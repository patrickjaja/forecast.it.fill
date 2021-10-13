<?php

declare(strict_types = 1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Kernel\AbstractFacade;

class ActivityFacade extends AbstractFacade
{
    public function __construct(private ActivityFactory $activityFactory)
    {
    }

    public function collect(): ActivityDtoCollection
    {
        return $this->activityFactory->createActivityCollector()->collect();
    }
}
