<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivityDataImport;

use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\PeriodicalActivityDataImport\Business\PeriodicalActivityConfigReader;
use ForecastAutomation\PeriodicalActivityDataImport\Business\PeriodicalActivityDataImportProcess;
use JsonSchema\Validator;

class PeriodicalActivityDataImportFactory extends AbstractFactory
{
    public function createPeriodicalActivityDataImportProcess(): PeriodicalActivityDataImportProcess
    {
        return new PeriodicalActivityDataImportProcess(
            $this->createPeriodicalActivityConfigReader(),
            $this->getForecastClientFacade()
        );
    }

    public function createPeriodicalActivityConfigReader(): PeriodicalActivityConfigReader
    {
        return new PeriodicalActivityConfigReader(
            $_ENV['PERIODICAL_ACTIVITY_CONFIG'],
            'file://'.realpath(
                $this->getSchemaPath()
            ),
            $this->createValidator(),
            $this->getLogFacade(),
        );
    }

    public function getSchemaPath(): string
    {
        return __DIR__.DIRECTORY_SEPARATOR.'Business/Schema/periodical_activity_config_schema.json';
    }

    public function createValidator(): Validator
    {
        return new Validator();
    }

    public function getLogFacade(): LogFacade
    {
        return $this->getProvidedDependency(PeriodicalActivityDataImportDependencyProvider::LOG_FACADE);
    }

    public function getForecastClientFacade(): ForecastClientFacade
    {
        return $this->getProvidedDependency(PeriodicalActivityDataImportDependencyProvider::FORECAST_CLIENT_FACADE);
    }
}
