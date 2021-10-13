<?php

declare(strict_types = 1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivityDataImport;

use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\PeriodicalActivityDataImport\Business\PeriodicalActivityConfigReader;
use ForecastAutomation\PeriodicalActivityDataImport\Business\PeriodicalActivityDataImportProcess;
use ForecastAutomation\QueueClient\QueueClientFacade;
use JsonSchema\Validator;

class PeriodicalActivityDataImportFactory extends AbstractFactory
{
    public function __construct(private LogFacade $logFacade, private QueueClientFacade $queueClientFacade)
    {
    }

    public function createPeriodicalActivityDataImportProcess(): PeriodicalActivityDataImportProcess
    {
        return new PeriodicalActivityDataImportProcess(
            $this->createPeriodicalActivityConfigReader(),
            $this->queueClientFacade
        );
    }

    public function createPeriodicalActivityConfigReader(): PeriodicalActivityConfigReader
    {
        return new PeriodicalActivityConfigReader(
            $_ENV['PERIODICAL_ACTIVITY_CONFIG'],
            'file://' . realpath(
                $this->getSchemaPath()
            ),
            $this->createValidator(),
            $this->logFacade,
        );
    }

    public function getSchemaPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Business/Schema/periodical_activity_config_schema.json';
    }

    public function createValidator(): Validator
    {
        return new Validator();
    }
}
