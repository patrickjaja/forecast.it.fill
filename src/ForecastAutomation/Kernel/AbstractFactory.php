<?php

namespace ForecastAutomation\Kernel;

use ReflectionClass;

class AbstractFactory
{
    private Locator $locator;

    public function __construct()
    {
        $this->locator = new Locator($this);
    }

    public function getProvidedDependency(string $id)
    {
        return $this->locator->getProvidedDependency($id);
    }
}
