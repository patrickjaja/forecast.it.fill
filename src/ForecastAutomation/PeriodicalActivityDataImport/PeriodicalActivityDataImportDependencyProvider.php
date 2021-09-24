<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivityDataImport;

use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\Log\LogFacade;

class PeriodicalActivityDataImportDependencyProvider extends AbstractDependencyProvider
{
    public const LOG_FACADE = 'LOG_FACADE';
    public const FORECAST_CLIENT_FACADE = 'FORECAST_CLIENT_FACADE';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::LOG_FACADE, new LogFacade());
        $this->set(self::FORECAST_CLIENT_FACADE, new ForecastClientFacade());
    }
}
