<?php

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Log;

use ForecastAutomation\Kernel\AbstractFacade;
use ForecastAutomation\Log\Business\Logger;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\LogglyHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;
use Monolog\Processor\UidProcessor;

class LogFactory extends AbstractFacade
{
    public function createLogger(): Logger
    {
        return new Logger($this->createMonologger());
    }

    public function createMonologger(): MonologLogger
    {
        return (new MonologLogger($_ENV['APPLICATION_NAME']))
            ->setHandlers(
                [
                    $this->createStreamHandler(),
                    $this->createLogglyStreamHandler(),
                ]
            )
        ;
    }

    public function createLogglyStreamHandler(): LogglyHandler
    {
        return new LogglyHandler($_ENV['LOGGLY_CUSTOMER_TOKEN']);
    }

    public function createStreamHandler(): StreamHandler
    {
        $handler = new StreamHandler($this->getLogPath());

        $handler->setFormatter(new JsonFormatter());
        $handler->pushProcessor(new UidProcessor(32));

        return $handler;
    }

    public function getLogPath(): string
    {
        return 'php://stdout';
    }
}
