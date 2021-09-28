<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\GuzzleClient\Shared;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class GuzzleFactoryHelper extends TestCase
{
    public function createResolvedPromise($data): PromiseInterface
    {
        $resolvedPromise = new Promise(function () use (&$resolvedPromise, $data) {
            $resolvedPromise->resolve($data);
        });
        return $resolvedPromise;
    }
}
