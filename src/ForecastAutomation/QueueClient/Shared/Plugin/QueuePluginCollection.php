<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient\Shared\Plugin;

use ArrayAccess;
use Iterator;

class QueuePluginCollection implements Iterator, ArrayAccess
{
    /**
     * @var \ForecastAutomation\QueueClient\Shared\Plugin\QueuePluginInterface[]
     */
    public array $plugins;

    private int $position = 0;

    public function __construct(
        QueuePluginInterface ...$plugins
    ) {
        foreach ($plugins as $plugin) {
            $this->plugins[$plugin->getQueueName()] = $plugin;
        }
    }

    public function current(): QueuePluginInterface
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

    public function offsetGet($offset): QueuePluginInterface
    {
        if (! $this->offsetExists($offset)) {
            throw new \Exception(
                \sprintf(
                    'Unknown Queue %s, please register first to your configured queue dependencyprovider adapter.',
                    $offset
                )
            );
        }

        return $this->plugins[$offset];
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
