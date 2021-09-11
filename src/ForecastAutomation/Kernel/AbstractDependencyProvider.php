<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Kernel;

use Psr\Container\ContainerInterface;

class AbstractDependencyProvider implements ContainerInterface
{
    protected static array $instances;

    protected Locator $locator;

    public function __construct()
    {
        $this->provideDependencies(new Locator($this));
    }

    public function provideDependencies(Locator $locator): void
    {
    }

    public function get(string $id)
    {
        return static::$instances[$id];
    }

    public function has(string $id): bool
    {
        // TODO: Implement has() method.
    }

    public function set(string $id, $concrete): void
    {
        static::$instances[$id] = $concrete;
    }
}
