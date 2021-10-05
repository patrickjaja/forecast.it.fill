<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivityDataImport\Shared\Plugin;

use ForecastAutomation\Kernel\Shared\Plugin\AbstractCommandPlugin;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \ForecastAutomation\PeriodicalActivityDataImport\PeriodicalActivityDataImportFacade getFacade()
 */
class PeriodicalActivityDataImportConsoleCommandPlugin extends AbstractCommandPlugin
{
    public const COMMAND_NAME = 'forecast:import:periodical:activity';
    public const DESCRIPTION = 'This command will generate forecast.it activity, based on your personal configuration.';

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->startImportProcess(date('Y-m-d'));

        return self::SUCCESS;
    }
}
