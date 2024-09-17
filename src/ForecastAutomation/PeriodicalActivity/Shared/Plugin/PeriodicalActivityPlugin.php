<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivity\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * @method \ForecastAutomation\PeriodicalActivity\PeriodicalActivityFacade getFacade()
 */
class PeriodicalActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    public function collect(): PromiseInterface
    {
        $wrapPromise = new Promise(
            function () use (&$wrapPromise) {
                $periodicalActivity = $this->getFacade()->generateActivityToDate(date('Y-m-d 00:00'));
                $wrapPromise->resolve($periodicalActivity);
            }
        );

        return $wrapPromise;
    }
}
