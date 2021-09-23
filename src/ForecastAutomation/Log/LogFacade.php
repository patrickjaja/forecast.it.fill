<?php

namespace ForecastAutomation\Log;

use ForecastAutomation\Kernel\AbstractFacade;
use Throwable;

/**
 * @method \ForecastAutomation\Log\LogFactory getFactory()
 */
class LogFacade extends AbstractFacade
{
    public function error(string $message, Throwable $e = null): void
    {
        $this->getFactory()->createLogger()->error($message, $e);
    }
    public function info(string $message, array $context = []): void
    {
        $this->getFactory()->createLogger()->info($message, $context);
    }
}
