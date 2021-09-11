<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastDataImport\Business\Writer;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\ForecastClientFacade;

class ForecastActivityWriter
{
    public function __construct(private ForecastClientFacade $forecastClientFacade)
    {
    }

    public function writeActivities(ActivityDtoCollection $activityDtoCollection): void
    {
        $this->forecastClientFacade->writeActivities($activityDtoCollection);
    }
}
