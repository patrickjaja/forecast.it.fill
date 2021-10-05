<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Serializer;

use ForecastAutomation\Kernel\AbstractFacade;
use ForecastAutomation\Serializer\Shared\Config\SerializerConstants;

/**
 * @method \ForecastAutomation\Serializer\SerializerFactory getFactory()
 */
class SerializerFacade extends AbstractFacade
{
    //ToDo: Support original feature scope ie. normalize attributes path
    // see here https://symfony.com/doc/current/components/serializer.html
    // https://jmsyst.com/libs/serializer
    public function serialize(object|array $dto, string $format = SerializerConstants::FORMAT_JSON): string
    {
        return \json_encode((array) $dto, JSON_THROW_ON_ERROR);
//        return $this->getFactory()->createSerializer()->serialize($dto, $format);
    }

    public function deserialize(
        string $serializedData,
//        string $dtoClassPath,
        string $format = SerializerConstants::FORMAT_JSON
    ): array {
        return \json_decode($serializedData, true, 512, JSON_THROW_ON_ERROR);
//        return $this->getFactory()->createSerializer()->deserialize($serializedData, $dtoClassPath, $format);
    }
}
