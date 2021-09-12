<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\GitlabClient;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\ForecastClient\ForecastClientFactory;
use ForecastAutomation\ForecastClient\Shared\Dto\ForecastConfigDto;
use ForecastAutomation\GitlabClient\GitlabClientFacade;
use ForecastAutomation\GitlabClient\GitlabClientFactory;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabConfigDto;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers
 */
final class GitlabClientFacadeTest extends TestCase
{
    public function testCanReadEvents(): void
    {
        $events = $this->createGitlabClientFacade()->getEvents(
            new GitlabQueryDto('test')
        );
        static::assertSame('test-event', $events[0]->test);
    }

    private function createGitlabClientFacade(): GitlabClientFacade
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->onlyMethods(['request'])
            ->getMock()
        ;
        $clientMock
            ->method('request')
            ->willReturn(
                new Response(200, ['X-Foo' => 'Bar'], '[{"test":"test-event"}]')
            )
        ;

        $gitlabClientFactoryMock = $this->getMockBuilder(GitlabClientFactory::class)
            ->onlyMethods(['createClient', 'createGitlabConfigDto'])
            ->getMock()
        ;
        $gitlabClientFactoryMock
            ->method('createClient')
            ->willReturn($clientMock)
        ;

        $gitlabClientFactoryMock->method('createGitlabConfigDto')
            ->willReturn(new GitlabConfigDto('', ''))
        ;

        $gitlabClientFacadeMock = $this->getMockBuilder(GitlabClientFacade::class)
            ->onlyMethods(['getFactory'])
            ->getMock()
        ;
        $gitlabClientFacadeMock
            ->method('getFactory')
            ->willReturn($gitlabClientFactoryMock)
        ;

        return $gitlabClientFacadeMock;
    }
}
