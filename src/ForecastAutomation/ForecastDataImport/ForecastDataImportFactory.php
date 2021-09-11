<?php

declare(strict_types=1);

// This file is part of forecast.it.fill project. (c) Patrick Jaja <patrickjaja@web.de> This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.

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
