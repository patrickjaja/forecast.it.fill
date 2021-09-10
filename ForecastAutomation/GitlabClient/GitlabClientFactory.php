<?php

namespace ForecastAutomation\GitlabClient;

use ForecastAutomation\GitlabClient\Business\GitlabApi;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabConfigDto;
use ForecastAutomation\Kernel\AbstractFactory;
use GuzzleHttp\Client;

class GitlabClientFactory extends AbstractFactory
{
    public function createGitlabConfigDto(): GitlabConfigDto
    {
        return new GitlabConfigDto(
            $_ENV['GITLAB_URL'],
            $_ENV['GITLAB_TOKEN'],
        );
    }

    public function createGitlabApi(): GitlabApi
    {
        return new GitlabApi(
            new Client(['base_uri' => (string)$_ENV['GITLAB_URL']]),
            $this->createGitlabConfigDto(),
        );
    }
}
