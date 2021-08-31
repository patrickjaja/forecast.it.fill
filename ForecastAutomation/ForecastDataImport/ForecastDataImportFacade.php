<?php

namespace ForecastAutomation\ForecastDataImport;

use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method \ForecastAutomation\ForecastDataImport\ForecastDataImportFactory getFactory()
 */
class ForecastDataImportFacade extends AbstractFacade
{
    public function startImportProcess(): void
    {
        $this->getFactory()->createForecastDataImportProcess()->start();
    }
}
