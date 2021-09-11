<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastDataImport\Business;

use ForecastAutomation\Activity\ActivityFacade;
use ForecastAutomation\ForecastDataImport\Business\Writer\ForecastActivityWriter;

class ForecastDataImportProcess
{
    public function __construct(
        private ActivityFacade $activityFacade,
        private ForecastActivityWriter $forecastActivityWriter
    ) {
    }

    public function start(): void
    {
        $this->forecastActivityWriter->writeActivities($this->activityFacade->collect());
    }
}
