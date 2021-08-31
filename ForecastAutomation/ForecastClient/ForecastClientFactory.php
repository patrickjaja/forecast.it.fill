<?php

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
            new Client(['base_uri' => (string)$_ENV['FORECAST_HOST']]),
            $this->createForecastConfigDto(),
        );
    }
}
