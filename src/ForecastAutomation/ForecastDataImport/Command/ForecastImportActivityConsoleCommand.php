<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastDataImport\Command;

use ForecastAutomation\ForecastDataImport\ForecastDataImportFacade;
use ForecastAutomation\Kernel\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ForecastImportActivityConsoleCommand extends AbstractCommand
{
    public const COMMAND_NAME = 'forecast:import:activity';
    public const DESCRIPTION = 'This command will import your forecast.it activity, based on activated plugins.';

    public function __construct(private ForecastDataImportFacade $forecastDataImportFacade)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forecastDataImportFacade->startImportProcess();

        return self::SUCCESS;
    }
}
