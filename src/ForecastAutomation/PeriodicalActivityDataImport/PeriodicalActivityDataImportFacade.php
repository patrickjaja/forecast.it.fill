<?php

declare(strict_types = 1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivityDataImport;

use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method \ForecastAutomation\PeriodicalActivityDataImport\PeriodicalActivityDataImportFactory getFactory()
 */
class PeriodicalActivityDataImportFacade extends AbstractFacade
{
    public function __construct(private PeriodicalActivityDataImportFactory $periodicalActivityDataImportFactory)
    {
    }

    public function startImportProcess(string $periodicalDate): int
    {
        return $this->periodicalActivityDataImportFactory->createPeriodicalActivityDataImportProcess()->start(
            $periodicalDate
        );
    }
}
