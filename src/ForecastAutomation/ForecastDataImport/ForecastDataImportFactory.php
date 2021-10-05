<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastDataImport;

use ForecastAutomation\Activity\ActivityFacade;
use ForecastAutomation\ForecastDataImport\Business\ForecastDataImportProcess;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\QueueClient\QueueClientFacade;

class ForecastDataImportFactory extends AbstractFactory
{
    public function createForecastDataImportProcess(): ForecastDataImportProcess
    {
        return new ForecastDataImportProcess(
            $this->getActivityFacade(),
            $this->getQueueClientFacade(),
        );
    }

    public function getActivityFacade(): ActivityFacade
    {
        return $this->getProvidedDependency(ForecastDataImportDependencyProvider::ACTIVITY_FACADE);
    }

    public function getQueueClientFacade(): QueueClientFacade
    {
        return $this->getProvidedDependency(ForecastDataImportDependencyProvider::QUEUE_CLIENT_FACADE);
    }
}
