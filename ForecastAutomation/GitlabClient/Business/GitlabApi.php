<?php

namespace ForecastAutomation\GitlabClient\Business;

use ForecastAutomation\GitlabClient\Shared\Dto\GitlabConfigDto;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
use GuzzleHttp\Client;

class GitlabApi
{
    private const EVENTS_API = '/api/v4/events';

    public function __construct(private Client $guzzleClient, private GitlabConfigDto $gitlabConfigDto)
    {
    }

    public function getEvents(GitlabQueryDto $queryDto): array
    {
        $res = $this->guzzleClient->request(
            'GET',
            self::EVENTS_API,
            ['query' => array_merge((array)$queryDto, $this->getToken())],
        );

        return \json_decode($res->getBody(), null, 512, JSON_THROW_ON_ERROR);
    }

    private function getToken(): array
    {
        return ['private_token' => $this->gitlabConfigDto->gitlabToken];
    }
}
