<?php

namespace ForecastAutomation\ForecastDataImport;

use ForecastAutomation\Activity\ActivityFacade;
use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\ForecastDataImport\Business\ForecastDataImportProcess;
use ForecastAutomation\ForecastDataImport\Business\Writer\ForecastActivityWriter;
use ForecastAutomation\Kernel\AbstractFactory;

class ForecastDataImportFactory extends AbstractFactory
{
    public function createForecastDataImportProcess(): ForecastDataImportProcess
    {
        return new ForecastDataImportProcess($this->getActivityFacade(), $this->createForecastActivityWriter());
    }
    public function getActivityFacade(): ActivityFacade
    {
        return $this->getProvidedDependency(ForecastDataImportDependencyProvider::ACTIVITY_FACADE);
    }
    public function getForecastClientFacade(): ForecastClientFacade
    {
        return $this->getProvidedDependency(ForecastDataImportDependencyProvider::FORECAST_CLIENT_FACADE);
    }
    public function createForecastActivityWriter(): ForecastActivityWriter
    {
        return new ForecastActivityWriter(
            $this->getForecastClientFacade(),
        );
    }
}
