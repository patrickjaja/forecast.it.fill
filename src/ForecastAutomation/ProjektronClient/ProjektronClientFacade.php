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
use ForecastAutomation\ProjektronClient\Business\PayloadDto;

/**
 * @method \ForecastAutomation\ProjektronClient\ProjektronClientFactory getFactory()
 */
class ProjektronClientFacade extends AbstractFacade
{
    public function writeActivities(ActivityDtoCollection $activityDtoCollection): int
    {
        $this->getFactory()->createProjektronApi()->writeActivities($activityDtoCollection);
        return 10;
    }
}
