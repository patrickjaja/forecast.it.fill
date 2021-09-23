<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\JiraClient\Shared\Plugin;

use ForecastAutomation\JiraClient\JiraClientFacade;
use ForecastAutomation\JiraClient\Shared\Plugin\JiraActivityPlugin;
use JiraRestApi\Issue\Comment;
use JiraRestApi\Request\Author;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers
 */
final class JiraActivityPluginTest extends TestCase
{
    public const TICKET_PATTERN = 'TESTNR-1';
    public const TESTUSER_EXAMPLE_COM = 'testuser@example.com';
    public const TICKET_COMMENT_UPDATED = '2021-01-02 11:00:00';
    public const TICKET_COMMENT_BODY = 'test';

    public function testCanReadEvents(): void
    {
        $comments = $this->createJiraActivityPlugin()->collect()->wait();
        static::assertSame(self::TICKET_PATTERN, $comments->offsetGet(0)->needle);
        static::assertSame('Ticket Bearbeitung: TESTNR-1 - test...', $comments->offsetGet(0)->description);
        static::assertSame('2021-01-02', $comments->offsetGet(0)->created->format('Y-m-d'));
        static::assertSame(JiraActivityPlugin::ACTIVITY_DURATION, $comments->offsetGet(0)->duration);
    }

    private function createJiraActivityPlugin(): JiraActivityPlugin
    {
        $gitlabClientFacadeMock = $this->getMockBuilder(JiraClientFacade::class)
            ->onlyMethods(['getComments'])
            ->getMock()
        ;

        $testComment = new Comment();
        $testComment->body = self::TICKET_COMMENT_BODY;
        $testComment->updated = self::TICKET_COMMENT_UPDATED;

        $testComments = new \stdClass();
        $testComments->comments = [$testComment];
        $testAuthor = new Author();
        $testAuthor->emailAddress = self::TESTUSER_EXAMPLE_COM;
        $testComment->author = $testAuthor;

        $gitlabClientFacadeMock
            ->method('getComments')
            ->willReturn([self::TICKET_PATTERN => [$testComment]])
        ;

        $gitlabActivityPluginMock = $this->getMockBuilder(JiraActivityPlugin::class)
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
