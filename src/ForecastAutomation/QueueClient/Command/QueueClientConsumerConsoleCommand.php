<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient\Command;

use ForecastAutomation\Kernel\Command\AbstractCommand;
use ForecastAutomation\QueueClient\QueueClientFacade;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueClientConsumerConsoleCommand extends AbstractCommand
{
    public const COMMAND_NAME = 'queue:client:consumer';
    public const DESCRIPTION = 'This command will consume messages in topics and call related processors.';
    public const ARGUMENT_QUEUE_NAME = 'queue_name';

    public function __construct(private QueueClientFacade $queueClientFacade)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);
        $this->addArgument(self::ARGUMENT_QUEUE_NAME, InputArgument::REQUIRED, 'Please add one of your registered Queue Plugins (QueuePluginCollection) as an argument.');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->queueClientFacade->consume($input->getArgument(self::ARGUMENT_QUEUE_NAME));

        return self::SUCCESS;
    }
}
