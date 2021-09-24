<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
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
use ForecastAutomationTests\GuzzleClient\Shared\GuzzleFactoryHelper;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers
 */
final class ActivityFacadeTest extends TestCase
{
    public const TEST_NEEDLE_1 = 'testNeedle1';
    public const TEST_DESCRIPTION = 'testDescription';
    public const TEST_CREATED = '2021-01-01 00:00:01';
    public const TEST_DURATION = 100;

    private GuzzleFactoryHelper $guzzleFactoryHelper;

    protected function setUp(): void
    {
        $this->guzzleFactoryHelper = new GuzzleFactoryHelper();
    }

    public function testCanCollectActivityFromPlugins(): void
    {
        $activityDto = $this->createActivityFacade()->collect()->current();
        static::assertSame(self::TEST_NEEDLE_1, $activityDto->needle);
        static::assertSame(self::TEST_DESCRIPTION, $activityDto->description);
        static::assertSame(self::TEST_DURATION, $activityDto->duration);
    }

    private function createActivityFacade(): ActivityFacade
    {
        $activityPluginMock = $this->getMockBuilder(ActivityPluginInterface::class)
            ->onlyMethods(['collect'])
            ->getMock()
        ;
        $activityPluginMock
            ->method('collect')
            ->willReturn(
                $this->guzzleFactoryHelper->createResolvedPromise(
                    new ActivityDtoCollection(
                        new ActivityDto(
                            self::TEST_NEEDLE_1,
                            self::TEST_DESCRIPTION,
                            new \DateTime(self::TEST_CREATED),
                            self::TEST_DURATION
                        )
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
            ->willReturn(new ActivityPluginCollection($activityPluginMock))
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
