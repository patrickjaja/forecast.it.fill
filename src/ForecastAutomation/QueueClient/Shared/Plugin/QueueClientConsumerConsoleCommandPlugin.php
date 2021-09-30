<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient\Shared\Plugin;

use ForecastAutomation\Kernel\Shared\Plugin\AbstractCommandPlugin;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Dto\MessageDto;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \ForecastAutomation\QueueClient\QueueClientFacade getFacade()
 */
class QueueClientConsumerConsoleCommandPlugin extends AbstractCommandPlugin
{
    public const COMMAND_NAME = 'queue:client:consumer';
    public const DESCRIPTION = 'This command will consume messages in topics and call related processors.';

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //ToDo: Consume createQueueConsumer
        $this->getFacade()->sendMessages(
            'test-queue5',
            new MessageCollectionDto(new MessageDto(['Hallo das ist ein Test4'], self::class))
        );
        $messageCollectionDto = $this->getFacade()->consume('test-queue5');

        foreach ($messageCollectionDto->messageDtos as $messageDto) {
            print_r($messageDto);
        }

        return self::SUCCESS;
    }
}
