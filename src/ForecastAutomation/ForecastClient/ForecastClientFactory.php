<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastClient;

use ForecastAutomation\Cache\CacheFacade;
use ForecastAutomation\ForecastClient\Business\ProjektronApi;
use ForecastAutomation\ForecastClient\Shared\Dto\ForecastConfigDto;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\Log\LogFacade;
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

    public function createForecastApi(): ProjektronApi
    {
        return new ProjektronApi(
            $this->createClient(),
            $this->createForecastConfigDto(),
            $this->getLogFacade(),
            $this->getCacheFacade(),
        );
    }

    public function createClient(): Client
    {
        return new Client(['base_uri' => (string) $_ENV['FORECAST_HOST']]);
    }

    public function getLogFacade(): LogFacade
    {
        return $this->getProvidedDependency(ForecastClientDependencyProvider::LOG_FACADE);
    }

    public function getCacheFacade(): CacheFacade
    {
        return $this->getProvidedDependency(ForecastClientDependencyProvider::CACHE_FACADE);
    }
}
