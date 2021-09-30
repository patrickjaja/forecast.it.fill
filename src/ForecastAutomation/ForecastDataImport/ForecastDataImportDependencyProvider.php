<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastDataImport;

use ForecastAutomation\Activity\ActivityFacade;
use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\QueueClient\QueueClientFacade;
use ForecastAutomation\Serializer\SerializerFacade;

class ForecastDataImportDependencyProvider extends AbstractDependencyProvider
{
    public const ACTIVITY_FACADE = 'ACTIVITY_FACADE';
    public const FORECAST_CLIENT_FACADE = 'FORECAST_CLIENT_FACADE';
    public const QUEUE_CLIENT_FACADE = 'QUEUE_CLIENT_FACADE';
    public const SERIALIZER_FACADE = 'SERIALIZER_FACADE';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::ACTIVITY_FACADE, new ActivityFacade());
        $this->set(self::FORECAST_CLIENT_FACADE, new ForecastClientFacade());
        $this->set(self::QUEUE_CLIENT_FACADE, new QueueClientFacade());
        $this->set(self::SERIALIZER_FACADE, new SerializerFacade());
    }
}
