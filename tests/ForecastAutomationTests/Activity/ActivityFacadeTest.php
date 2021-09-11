<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\Activity;

use ForecastAutomation\Activity\ActivityFacade;
use ForecastAutomation\Activity\ActivityFactory;
use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ActivityFacadeTest extends TestCase
{
    public const TEST_NEEDLE_1 = 'testNeedle1';
    public const TEST_DESCRIPTION = 'testDescription';
    public const TEST_CREATED = '2021-01-01 00:00:01';
    public const TEST_DURATION = 100;

    public function testCanCollectActivityFromPlugins(): void
    {
        $activityDto = $this->createActivityFacade()->collect()->current();
        static::assertSame(self::TEST_NEEDLE_1, $activityDto->needle);
        static::assertSame(self::TEST_DESCRIPTION, $activityDto->description);
        static::assertSame(self::TEST_DURATION, $activityDto->duration);
        static::assertSame(new \DateTime(self::TEST_CREATED), $activityDto->created);
    }

    private function createActivityFacade(): ActivityFacade
    {
        $nullActivityPluginMock = $this->getMockBuilder(ActivityPluginInterface::class)
            ->onlyMethods(['collect'])
            ->getMock()
        ;
        $nullActivityPluginMock
            ->method('collect')
            ->willReturn(
                new ActivityDtoCollection(
                    new ActivityDto(
                        self::TEST_NEEDLE_1,
                        self::TEST_DESCRIPTION,
                        new \DateTime(self::TEST_CREATED),
                        self::TEST_DURATION
                    )
                )
            )
        ;

        $activityFactoryMock = $this->getMockBuilder(ActivityFactory::class)
            ->onlyMethods(['getActivityPlugins'])
            ->getMock()
        ;
        $activityFactoryMock
            ->method('getActivityPlugins')
            ->willReturn(new ActivityPluginCollection($nullActivityPluginMock))
        ;

        $activityFacadeMock = $this->getMockBuilder(ActivityFacade::class)
            ->onlyMethods(['getFactory'])
            ->getMock()
        ;
        $activityFacadeMock
            ->method('getFactory')
            ->willReturn($activityFactoryMock)
        ;

        return $activityFacadeMock;
    }
}
