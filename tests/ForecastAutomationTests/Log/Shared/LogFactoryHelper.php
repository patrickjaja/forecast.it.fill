<?php

namespace ForecastAutomationTests\Log\Shared;

use ForecastAutomation\Log\LogFacade;
use PHPUnit\Framework\TestCase;

class LogFactoryHelper extends TestCase
{
    public function createLogFacadeMock(): LogFacade
    {
        return $this->getMockBuilder(LogFacade::class)
            ->getMock();
    }
}
