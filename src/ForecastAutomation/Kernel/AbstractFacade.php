<?php

namespace ForecastAutomation\Kernel;

use ReflectionClass;

class AbstractFacade
{
    private Locator $locator;

    public function __construct() { $this->locator = new Locator($this); }

    public function getFactory():object {
        return $this->locator->getFactory();
    }
}
