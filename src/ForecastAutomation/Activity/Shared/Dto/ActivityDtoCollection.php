<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity\Shared\Dto;

use ArrayAccess;
use Iterator;

class ActivityDtoCollection implements Iterator, ArrayAccess
{
    /**
     * @var \ForecastAutomation\Activity\Shared\Dto\ActivityDto[]
     */
    private array $activityDtos;

    private int $position = 0;

    public function __construct(
        ActivityDto ...$activityDtos
    ) {
        $this->activityDtos = $activityDtos;
    }

    public function current(): ActivityDto
    {
        return $this->activityDtos[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return \array_key_exists($this->position, $this->activityDtos);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function offsetExists($offset): bool
    {
        return \array_key_exists($offset, $this->activityDtos);
    }

    public function offsetGet($offset): mixed
    {
        return $this->array[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->activityDtos[] = $value;
        } else {
            $this->activityDtos[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->activityDtos[$offset]);
    }

    public function merge(self $collection): self
    {
        $this->activityDtos = array_merge($this->activityDtos, $collection->activityDtos);

        return $this;
    }
}
