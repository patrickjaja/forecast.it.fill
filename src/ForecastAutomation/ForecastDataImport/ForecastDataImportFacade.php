<?php

declare(strict_types = 1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastDataImport;

use ForecastAutomation\Kernel\AbstractFacade;

class ForecastDataImportFacade extends AbstractFacade
{
    public function __construct(private ForecastDataImportFactory $forecastDataImportFactory)
    {
    }

    public function startImportProcess(): int
    {
        return $this->forecastDataImportFactory
            ->createForecastDataImportProcess()
            ->start();
    }
}
