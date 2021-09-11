<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
