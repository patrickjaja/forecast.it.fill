<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastDataImport\Shared\Plugin;

use ForecastAutomation\Kernel\Shared\Plugin\AbstractCommandPlugin;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \ForecastAutomation\ForecastDataImport\ForecastDataImportFacade getFacade()
 */
class ForecastImportActivityConsoleCommandPlugin extends AbstractCommandPlugin
{
    public const COMMAND_NAME = 'forecast:import:activity';
    public const DESCRIPTION = 'This command will run installer for search';

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->startImportProcess();

        return self::SUCCESS;
    }
}
