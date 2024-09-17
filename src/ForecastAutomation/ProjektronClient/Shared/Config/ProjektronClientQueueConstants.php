<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ProjektronClient\Shared\Config;

interface ProjektronClientQueueConstants
{
    public const QUEUE_NAME = 'projektron.send.activity.queue';
    public const IMPORT_EVENT = 'IMPORT_EVENT';
}
