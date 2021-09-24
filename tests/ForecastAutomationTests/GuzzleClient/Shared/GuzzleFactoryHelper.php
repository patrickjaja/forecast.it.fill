<?php

namespace ForecastAutomationTests\GuzzleClient\Shared;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class GuzzleFactoryHelper extends TestCase
{
    public function createResolvedPromise($data): PromiseInterface
    {
        $resolvedPromise = new Promise(function () use (&$resolvedPromise,$data) {
            $resolvedPromise->resolve($data);
        });
        return $resolvedPromise;
    }
}
