<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\ForecastDataImport;

use ForecastAutomation\Activity\ActivityFacade;
use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastDataImport\ForecastDataImportFacade;
use ForecastAutomation\ForecastDataImport\ForecastDataImportFactory;
use ForecastAutomation\QueueClient\QueueClientFacade;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers
 */
final class ForecastDataImportFacadeTest extends TestCase
{
    public function testCanStartTheImportProcess(): void
    {
        $writtenActivities = $this->createForecastDataImportFacade()->startImportProcess();
        static::assertSame(1, $writtenActivities);
    }

    private function createForecastDataImportFacade(): ForecastDataImportFacade
    {
        $activityFacadeMock = $this->getMockBuilder(ActivityFacade::class)
            ->onlyMethods(['collect'])
            ->getMock()
        ;
        $activityFacadeMock
            ->method('collect')
            ->willReturn(
                new ActivityDtoCollection(
                    new ActivityDto('test-needle', 'test-description', new \DateTime(), 100)
                )
            )
        ;

        $forecastClientFacadeMock = $this->getMockBuilder(QueueClientFacade::class)
            ->getMock()
        ;

        $forecastDataImportFactoryMock = $this->getMockBuilder(ForecastDataImportFactory::class)
            ->onlyMethods(['getActivityFacade', 'getQueueClientFacade'])
            ->getMock()
        ;
        $forecastDataImportFactoryMock
            ->method('getActivityFacade')
            ->willReturn($activityFacadeMock)
        ;
        $forecastDataImportFactoryMock
            ->method('getQueueClientFacade')
            ->willReturn($forecastClientFacadeMock)
        ;

        $forecastDataImportFacadeMock = $this->getMockBuilder(ForecastDataImportFacade::class)
            ->onlyMethods(['getFactory'])
            ->getMock()
        ;
        $forecastDataImportFacadeMock
            ->method('getFactory')
            ->willReturn($forecastDataImportFactoryMock)
        ;

        return $forecastDataImportFacadeMock;
    }
}
