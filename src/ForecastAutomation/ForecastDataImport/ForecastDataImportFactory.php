<?php

declare(strict_types = 1);

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
    public function __construct(
        private ActivityFacade $activityFacade,
        private QueueClientFacade $queueClientFacade,
    ) {

    }

    public function createForecastDataImportProcess(): ForecastDataImportProcess
    {
        return new ForecastDataImportProcess(
            $this->activityFacade,
            $this->queueClientFacade,
        );
    }
}
