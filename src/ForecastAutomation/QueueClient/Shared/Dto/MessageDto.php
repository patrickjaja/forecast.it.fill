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
// https://docs.dapr.io/developing-applications/building-blocks/pubsub/pubsub-overview/
class MessageDto extends AbstractDto
{
    public function __construct(
        public array $data,
        public string $source = 'className',
        public string $type = 'eventName',
        public string $specversion = '1.0',
        public string $datacontenttype = 'application/json',
        public string $id = '',
        public int $time = 0,
    ) {
    }
}
