<?php

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastClient;

use ForecastAutomation\Cache\CacheFacade;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\Log\LogFacade;

class ForecastClientDependencyProvider extends AbstractDependencyProvider
{
    public const LOG_FACADE = 'LOGGER_FACADE';
    public const CACHE_FACADE = 'CACHE_FACADE';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::LOG_FACADE, new LogFacade());
        $this->set(self::CACHE_FACADE, new CacheFacade());
    }
}
