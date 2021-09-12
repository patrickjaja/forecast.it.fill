<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\GitlabClient\Shared\Plugin;

use ForecastAutomation\GitlabClient\GitlabClientFacade;
use ForecastAutomation\GitlabClient\GitlabClientFactory;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabConfigDto;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
use ForecastAutomation\GitlabClient\Shared\Plugin\GitlabActivityPlugin;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers
 */
final class GitlabActivityPluginTest extends TestCase
{
    public const TICKET_PATTERN = 'TESTNR';

    public function testCanReadEvents(): void
    {
        $_ENV['GITLAB_PATTERN']= self::TICKET_PATTERN;
        $activityDtoCollection = $this->createGitlabActivityPlugin()->collect();
        static::assertSame(self::TICKET_PATTERN.'-1234', $activityDtoCollection->offsetGet(0)->needle);
        static::assertSame('Entwicklungsprozess: TESTNR-1234 (commented on)', $activityDtoCollection->offsetGet(0)->description);
        static::assertSame('2021-01-01', $activityDtoCollection->offsetGet(0)->created->format('Y-m-d'));
        static::assertSame(GitlabActivityPlugin::ACTIVITY_DURATION, $activityDtoCollection->offsetGet(0)->duration);
    }

    private function createGitlabActivityPlugin(): GitlabActivityPlugin
    {
        $gitlabClientFacadeMock = $this->getMockBuilder(GitlabClientFacade::class)
            ->onlyMethods(['getEvents'])
            ->getMock()
        ;

        $testEvent1 = new \stdClass();
        $testEvent1->target_title = self::TICKET_PATTERN.'-1234';
        $testEvent1->action_name = GitlabActivityPlugin::ALLOWED_ACTION_NAMES[0];
        $testEvent1->created_at = '2021-01-01 00:00:00';

        $gitlabClientFacadeMock
            ->method('getEvents')
            ->willReturn(['event1'=>$testEvent1])
        ;

        $gitlabActivityPluginMock = $this->getMockBuilder(GitlabActivityPlugin::class)
            ->onlyMethods(['getFacade'])
            ->getMock()
        ;
        $gitlabActivityPluginMock
            ->method('getFacade')
            ->willReturn($gitlabClientFacadeMock)
        ;



        return $gitlabActivityPluginMock;
    }
}
