<?php

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

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->startImportProcess();

        return self::SUCCESS;
    }
}
