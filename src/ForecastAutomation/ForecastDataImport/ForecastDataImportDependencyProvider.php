<?php

namespace ForecastAutomation\ForecastDataImport;

use ForecastAutomation\Activity\ActivityFacade;
use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;

class ForecastDataImportDependencyProvider extends AbstractDependencyProvider
{
    public const ACTIVITY_FACADE = 'ACTIVITY_FACADE';
    public const FORECAST_CLIENT_FACADE = 'FORECAST_CLIENT_FACADE';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::ACTIVITY_FACADE, new ActivityFacade());
        $this->set(self::FORECAST_CLIENT_FACADE, new ForecastClientFacade());
    }
}
