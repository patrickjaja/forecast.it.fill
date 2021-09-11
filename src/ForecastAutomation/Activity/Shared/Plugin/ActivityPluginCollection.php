<?php

declare(strict_types=1);

// This file is part of forecast.it.fill project. (c) Patrick Jaja <patrickjaja@web.de> This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.

namespace ForecastAutomation\Activity\Shared\Plugin;

use ArrayAccess;
use Iterator;

class ActivityPluginCollection implements Iterator, ArrayAccess
{
    /**
     * @var \ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface[]
     */
    private array $plugins;

    private int $position = 0;

    public function __construct(
        ActivityPluginInterface ...$plugins
    ) {
        $this->plugins = $plugins;
    }

    public function current(): ActivityPluginInterface
    {
        return $this->plugins[$this->position];
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
        return \array_key_exists($this->position, $this->plugins);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function offsetExists($offset): bool
    {
        return \array_key_exists($offset, $this->plugins);
    }

    public function offsetGet($offset): mixed
    {
        return $this->array[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->plugins[] = $value;
        } else {
            $this->plugins[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->plugins[$offset]);
    }
}
