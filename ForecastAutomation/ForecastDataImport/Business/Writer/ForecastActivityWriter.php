<?php

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
