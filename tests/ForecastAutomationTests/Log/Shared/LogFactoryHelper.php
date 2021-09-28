<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\Log\Shared;

use ForecastAutomation\Log\LogFacade;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class LogFactoryHelper extends TestCase
{
    public function createLogFacadeMock(): LogFacade
    {
        return $this->getMockBuilder(LogFacade::class)
            ->getMock()
        ;
    }
}
