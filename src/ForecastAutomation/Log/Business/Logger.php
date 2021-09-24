<?php

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Log\Business;

use Psr\Log\LoggerInterface;
use Throwable;

class Logger
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function info(string $message, array $context): void
    {
        $this->logger->info(
            $message,
            [
                'message' => $message,
                'context' => $context,
            ]
        );
    }

    public function error(string $message, Throwable $e = null): void
    {
        $this->logger->error(
            $message,
            [
                'message' => $message,
                'throwable' => $e,
            ]
        );
    }
}
