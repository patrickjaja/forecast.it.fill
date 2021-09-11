<?php

namespace ForecastAutomation\Kernel\Shared\Plugin;

use ForecastAutomation\Kernel\Locator;

class AbstractPlugin
{
    private Locator $locator;

    public function __construct()
    {
        $this->locator = new Locator($this);
    }

    public function getFacade(): object
    {
        return $this->locator->getFacade();
    }
}
