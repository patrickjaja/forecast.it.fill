<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\KafkaClient;

use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\Serializer\SerializerFacade;

class KafkaClientDependencyProvider extends AbstractDependencyProvider
{
    public const SERIALIZER_FACADE = 'SERIALIZER_FACADE';
    public const LOG_FACADE = 'LOG_FACADE';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::SERIALIZER_FACADE, new SerializerFacade());
        $this->set(self::LOG_FACADE, new LogFacade());
    }
}
