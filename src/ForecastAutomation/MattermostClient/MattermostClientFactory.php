<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient;

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
            $this->createClient(),
            $this->createMattermostConfigDto(),
        );
    }

    public function createClient(): Client
    {
        return new Client(['base_uri' => (string)$_ENV['MATTERMOST_HOST']]);
    }
}
