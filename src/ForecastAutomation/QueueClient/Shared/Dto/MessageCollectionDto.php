<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

// https://github.com/cloudevents/spec/blob/v1.0.1/json-format.md#32-examples
class MessageCollectionDto extends AbstractDto
{
    /**
     * @var \ForecastAutomation\QueueClient\Shared\Dto\MessageDto[]
     */
    public array $messageDtos;

    public function __construct(
        MessageDto ...$messageDtos,
    ) {
        $this->messageDtos = $messageDtos;
    }
}
