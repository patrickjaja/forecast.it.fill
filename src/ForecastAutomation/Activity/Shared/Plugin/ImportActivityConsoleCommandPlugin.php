<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity\Shared\Plugin;

use ForecastAutomation\Kernel\Shared\Plugin\AbstractCommandPlugin;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \ForecastAutomation\Activity\ActivityFacade getFacade()
 */
class ImportActivityConsoleCommandPlugin extends AbstractCommandPlugin
{
    public const COMMAND_NAME = 'import:activity';
    public const DESCRIPTION = 'This command will import your personal activity based on activated plugins.';

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->send(
            $this->getFacade()->collect()
        );

        return self::SUCCESS;
    }
}
