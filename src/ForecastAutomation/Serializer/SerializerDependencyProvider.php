<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Serializer;

use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SerializerDependencyProvider extends AbstractDependencyProvider
{
    public const SERIALIZE_NORMALIZER_PLUGINS = 'SERIALIZE_NORMALIZER_PLUGINS';
    public const SERIALIZE_ENCODER_PLUGINS = 'SERIALIZE_ENCODER_PLUGINS';

    public function provideDependencies(ContainerInterface $container): void
    {
        $this->set(
            self::SERIALIZE_ENCODER_PLUGINS,
            [
                new JsonEncoder(),
            ]
        );
        $this->set(self::SERIALIZE_NORMALIZER_PLUGINS, [new ObjectNormalizer()]);
    }
}
