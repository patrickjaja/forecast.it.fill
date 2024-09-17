<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ProjektronClient;

use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\ProjektronClient\Business\ProjektronApi;

class ProjektronClientFactory extends AbstractFactory
{
    public function createProjektronApi(): ProjektronApi
    {
        return new ProjektronApi(
            $_ENV['PROJEKTRON_API_ENDPOINT'],
            $_ENV['PROJEKTRON_COOKIE_HEADER_VALUE'],
            $_ENV['PROJEKTRON_USERNAME'],
        );
    }
}
