<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastClient\Shared\Config;

interface ForecastClientQueueConstants
{
    public const QUEUE_NAME = 'ACTIVITY_TOPIC';
    public const IMPORT_EVENT = 'IMPORT_EVENT';
}
