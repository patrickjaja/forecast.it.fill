<?php

declare(strict_types=1);

// This file is part of forecast.it.fill project. (c) Patrick Jaja <patrickjaja@web.de> This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.

namespace ForecastAutomationTests\ForecastClient;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\ForecastClient\ForecastClientFactory;
use ForecastAutomation\ForecastClient\Shared\Dto\ForecastConfigDto;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ForecastClientFacadeTest extends TestCase
{
    public function testCanWriteActivityCollection(): void
    {
        $writtenActivities = $this->createForecastClientFacade()->writeActivities(
            new ActivityDtoCollection(new ActivityDto('test-ticket-number', 'test', new \DateTime(), 1))
        );
        static::assertSame(1, $writtenActivities);
    }

    private function createForecastClientFacade(): ForecastClientFacade
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->onlyMethods(['request'])
            ->getMock()
        ;
        $clientMock
            ->method('request')
            ->willReturn(
                new Response(200, ['X-Foo' => 'Bar'], '[{"title":"test-ticket-number","id":1}]')
            )
        ;

        $forecastClientFactoryMock = $this->getMockBuilder(ForecastClientFactory::class)
            ->onlyMethods(['createClient', 'createForecastConfigDto'])
            ->getMock()
        ;
        $forecastClientFactoryMock
            ->method('createClient')
            ->willReturn($clientMock)
        ;

        $forecastClientFactoryMock->method('createForecastConfigDto')
            ->willReturn(new ForecastConfigDto('', '', '', '', ''))
        ;

        $forecastClientFacadeMock = $this->getMockBuilder(ForecastClientFacade::class)
            ->onlyMethods(['getFactory'])
            ->getMock()
        ;
        $forecastClientFacadeMock
            ->method('getFactory')
            ->willReturn($forecastClientFactoryMock)
        ;

        return $forecastClientFacadeMock;
    }
}
