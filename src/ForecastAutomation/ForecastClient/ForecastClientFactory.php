<?php

declare(strict_types=1);

// This file is part of forecast.it.fill project. (c) Patrick Jaja <patrickjaja@web.de> This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.

namespace ForecastAutomation\ForecastClient;

use ForecastAutomation\ForecastClient\Business\ForecastApi;
use ForecastAutomation\ForecastClient\Shared\Dto\ForecastConfigDto;
use ForecastAutomation\Kernel\AbstractFactory;
use GuzzleHttp\Client;

class ForecastClientFactory extends AbstractFactory
{
    public function createForecastConfigDto(): ForecastConfigDto
    {
        return new ForecastConfigDto(
            $_ENV['FORECAST_HOST'],
            $_ENV['FORECAST_API_KEY'],
            $_ENV['FORECAST_PROJECT_ID'],
            $_ENV['FORECAST_PERSON_ID'],
            $_ENV['FORECAST_FALLBACK_TASK_ID'],
        );
    }

    public function createForecastApi(): ForecastApi
    {
        return new ForecastApi(
            $this->createClient(),
            $this->createForecastConfigDto(),
        );
    }

    public function createClient(): Client
    {
        return new Client(['base_uri' => (string) $_ENV['FORECAST_HOST']]);
    }
}
