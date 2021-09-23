<?php

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
        return (new MonologLogger(getenv('APPLICATION_NAME')))
            ->setHandlers(
                [
                    $this->createStreamHandler(),
                    $this->createLogglyStreamHandler(),
                ]
            );
    }

    public function createLogglyStreamHandler(): LogglyHandler
    {
        return new LogglyHandler(getenv('LOGGLY_CUSTOMER_TOKEN'));
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
