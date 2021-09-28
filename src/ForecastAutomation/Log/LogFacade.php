<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
