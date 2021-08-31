<?php

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
