<?php

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
