<?php

namespace ForecastAutomation\MattermostClient;

use ForecastAutomation\GitlabClient\Business\GitlabApi;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabConfigDto;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\MattermostClient\Business\MattermostApi;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostConfigDto;
use GuzzleHttp\Client;

class MattermostClientFactory extends AbstractFactory
{
    public function createMattermostConfigDto(): MattermostConfigDto
    {
        return new MattermostConfigDto(
            $_ENV['MATTERMOST_HOST'],
            $_ENV['MATTERMOST_USER_ID'],
            $_ENV['MATTERMOST_PASSWORD'],
            $_ENV['MATTERMOST_TEAM_ID'],
        );
    }

    public function createMattermostApi(): MattermostApi
    {
        return new MattermostApi(
            new Client(['base_uri' => (string)$_ENV['MATTERMOST_HOST']]),
            $this->createMattermostConfigDto(),
        );
    }
}
