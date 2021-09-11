<?php

declare(strict_types=1);

// This file is part of forecast.it.fill project. (c) Patrick Jaja <patrickjaja@web.de> This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.

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
