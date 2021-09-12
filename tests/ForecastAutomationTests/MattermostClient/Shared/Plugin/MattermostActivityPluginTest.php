<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\MattermostClient\Shared\Plugin;

use ForecastAutomation\GitlabClient\GitlabClientFacade;
use ForecastAutomation\GitlabClient\Shared\Plugin\GitlabActivityPlugin;
use ForecastAutomation\MattermostClient\MattermostClientFacade;
use ForecastAutomation\MattermostClient\Shared\Plugin\MattermostActivityPlugin;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers
 */
final class MattermostActivityPluginTest extends TestCase
{
    public const TICKET_PATTERN = 'TESTNR';

    public function testCanReadEvents(): void
    {
        $_ENV['MATTERMOST_PATTERN'] = self::TICKET_PATTERN;
        $activityDtoCollection = $this->createMattermostActivityPlugin()->collect();
        static::assertSame(self::TICKET_PATTERN.'-1234', $activityDtoCollection->offsetGet(0)->needle);
        static::assertSame(MattermostActivityPlugin::POST_SUFFIX.': TESTNR-1234', $activityDtoCollection->offsetGet(0)->description);
        static::assertSame((new \DateTime())->format('Y-m-d'), $activityDtoCollection->offsetGet(0)->created->format('Y-m-d'));
        static::assertSame(MattermostActivityPlugin::ACTIVITY_DURATION, $activityDtoCollection->offsetGet(0)->duration);
    }

    private function createMattermostActivityPlugin(): MattermostActivityPlugin
    {
        $mattermostClientFacadeMock = $this->getMockBuilder(MattermostClientFacade::class)
            ->onlyMethods(['getChannel', 'getPosts'])
            ->getMock()
        ;

        $testChannel = new \stdClass();
        $testChannel->id = 'test-channel-id';

        $mattermostClientFacadeMock
            ->method('getChannel')
            ->willReturn([$testChannel])
        ;
        $mattermostClientFacadeMock
            ->method('getPosts')
            ->willReturn([['message'=>'testmessage '.self::TICKET_PATTERN.'-1234','create_at'=>(new \DateTime())->format('U')*1000]])
        ;

        $mattermostActivityPluginMock = $this->getMockBuilder(MattermostActivityPlugin::class)
            ->onlyMethods(['getFacade'])
            ->getMock()
        ;
        $mattermostActivityPluginMock
            ->method('getFacade')
            ->willReturn($mattermostClientFacadeMock)
        ;

        return $mattermostActivityPluginMock;
    }
}
