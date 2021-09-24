<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Kernel;

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
