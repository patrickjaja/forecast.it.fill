<?php

namespace ForecastAutomation\Activity\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;

interface ActivityPluginInterface
{
    public function collect(): ActivityDtoCollection;
}
