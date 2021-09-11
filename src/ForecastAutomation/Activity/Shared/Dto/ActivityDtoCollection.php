<?php

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
        return array_key_exists($this->position, $this->activityDtos);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->activityDtos);
    }

    public function offsetGet($offset): mixed
    {
        return $this->array[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->activityDtos[] = $value;
        } else {
            $this->activityDtos[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->activityDtos[$offset]);
    }

    public function merge(ActivityDtoCollection $collection): ActivityDtoCollection
    {
        $this->activityDtos = array_merge($this->activityDtos, $collection->activityDtos);
        return $this;
    }
}
