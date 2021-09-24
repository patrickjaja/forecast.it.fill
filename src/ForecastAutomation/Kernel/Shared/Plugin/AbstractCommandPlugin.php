<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Kernel\Shared\Plugin;

use ForecastAutomation\Kernel\Locator;
use Symfony\Component\Console\Command\Command;

class AbstractCommandPlugin extends Command
{
    private Locator $locator;

    public function __construct()
    {
        $this->locator = new Locator($this);
        parent::__construct();
    }

    public function getFacade(): object
    {
        return $this->locator->getFacade();
    }
}
