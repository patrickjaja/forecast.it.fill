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
        public array $data = [],
        public string $queueName = 'queueName',
        public string $type = 'eventName',
        public string $specversion = '1.0',
        public string $datacontenttype = 'application/json',
        public string $id = '',
        public int $time = 0,
        public array $adapterMetaResponse = [],
    ) {
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setQueueName(string $queueName): self
    {
        $this->queueName = $queueName;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setSpecversion(string $specversion): self
    {
        $this->specversion = $specversion;

        return $this;
    }

    public function setDatacontenttype(string $datacontenttype): self
    {
        $this->datacontenttype = $datacontenttype;

        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function setAdapterMetaResponse(array $adapterMetaResponse): self
    {
        $this->adapterMetaResponse = $adapterMetaResponse;

        return $this;
    }
}
