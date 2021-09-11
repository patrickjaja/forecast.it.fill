<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
            ['query' => array_merge((array) $queryDto, $this->getToken())],
        );

        return json_decode((string) $res->getBody(), null, 512, JSON_THROW_ON_ERROR);
    }

    private function getToken(): array
    {
        return ['private_token' => $this->gitlabConfigDto->gitlabToken];
    }
}
