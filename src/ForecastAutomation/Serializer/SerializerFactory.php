<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Serializer;

use ForecastAutomation\Kernel\AbstractFactory;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory extends AbstractFactory
{
    public function createSerializer(): Serializer
    {
        return new Serializer($this->getNormalizerPlugins(), $this->getEncoderPlugins());
    }

    /**
     * @return NormalizerInterface[] array
     */
    public function getNormalizerPlugins(): array
    {
        return $this->getProvidedDependency(SerializerDependencyProvider::SERIALIZE_NORMALIZER_PLUGINS);
    }

    /**
     * @return EncoderInterface[] array
     */
    public function getEncoderPlugins(): array
    {
        return $this->getProvidedDependency(SerializerDependencyProvider::SERIALIZE_ENCODER_PLUGINS);
    }
}
