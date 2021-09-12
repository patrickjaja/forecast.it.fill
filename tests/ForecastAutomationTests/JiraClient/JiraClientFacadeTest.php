<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\JiraClient;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\ForecastClient\ForecastClientFactory;
use ForecastAutomation\ForecastClient\Shared\Dto\ForecastConfigDto;
use ForecastAutomation\GitlabClient\GitlabClientFacade;
use ForecastAutomation\GitlabClient\GitlabClientFactory;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabConfigDto;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
use ForecastAutomation\JiraClient\JiraClientFacade;
use ForecastAutomation\JiraClient\JiraClientFactory;
use ForecastAutomation\JiraClient\Shared\Dto\JiraConfigDto;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JiraRestApi\Issue\Comment;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Issue\IssueSearchResult;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraClient;
use JiraRestApi\Request\Author;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers
 */
final class JiraClientFacadeTest extends TestCase
{
    const TESTUSER_EXAMPLE_COM = 'testuser@example.com';
    const TICKET_COMMENT_UPDATED = '2021-01-02 11:00:00';
    const TICKET_COMMENT_BODY = 'test';

    public function testCanReadEvents(): void
    {
        $comments = $this->createGitlabClientFacade()->getComments(
            '2021-01-02 10:00:00'
        );
        static::assertArrayHasKey('test-key',$comments);
        static::assertSame(self::TICKET_COMMENT_BODY,$comments['test-key'][0]->body);
        static::assertSame('testuser@example.com',$comments['test-key'][0]->author->emailAddress);
        static::assertSame(self::TICKET_COMMENT_UPDATED,$comments['test-key'][0]->updated);
    }

    private function createGitlabClientFacade(): JiraClientFacade
    {
        $issueServiceMock = $this->getMockBuilder(IssueService::class)->disableOriginalConstructor()
            ->onlyMethods(['search','getComments'])
            ->getMock()
        ;

        $issueSearchResult = new IssueSearchResult();

        $testIssue = new Issue();
        $testIssue->key = 'test-key';
        $issueSearchResult->setIssues([$testIssue]);
        $this->returnValue($issueSearchResult);

        $issueServiceMock
            ->method('search')
            ->willReturn(
                $issueSearchResult
            )
        ;

        $testComment = new Comment();
        $testComment->body= self::TICKET_COMMENT_BODY;
        $testComment->updated= self::TICKET_COMMENT_UPDATED;

        $testComments = new \stdClass();
        $testComments->comments = [$testComment];
        $testAuthor = new Author();
        $testAuthor->emailAddress = self::TESTUSER_EXAMPLE_COM;
        $testComment->author = $testAuthor;
        $issueServiceMock
            ->method('getComments')
            ->willReturn(
                $testComments
            )
        ;

        $jiraClientFactoryMock = $this->getMockBuilder(JiraClientFactory::class)
            ->onlyMethods(['createJiraClient', 'createJiraConfigDto'])
            ->getMock()
        ;
        $jiraClientFactoryMock
            ->method('createJiraClient')
            ->willReturn($issueServiceMock)
        ;

        $jiraClientFactoryMock->method('createJiraConfigDto')
            ->willReturn(new JiraConfigDto('', '', self::TESTUSER_EXAMPLE_COM,0,''))
        ;

        $jiraClientFacadeMock = $this->getMockBuilder(JiraClientFacade::class)
            ->onlyMethods(['getFactory'])
            ->getMock()
        ;
        $jiraClientFacadeMock
            ->method('getFactory')
            ->willReturn($jiraClientFactoryMock)
        ;

        return $jiraClientFacadeMock;
    }
}
