<?php

namespace ForecastAutomation\Kernel\Shared\Plugin;

use ForecastAutomation\Kernel\Locator;
use Symfony\Component\Console\Command\Command;

class AbstractCommandPlugin extends Command
{
    private Locator $locator;

    public function __construct() {
        $this->locator = new Locator($this);
        parent::__construct();
    }

    public function getFacade():object {
        return $this->locator->getFacade();
    }
}
