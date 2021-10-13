<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Kernel;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AbstractDependencyProvider extends Bundle
//    implements ContainerInterface
{
    protected static array $instances;

    protected Locator $locator;

    public function boot()
    {
        parent::boot();
        $this->provideDependencies($this->container);
    }

    //ToDo: Pass Container (DI) with module dynamic resolver of KernelConfig Patterns
    public function provideDependencies(ContainerInterface $container): void
    {
    }

    public function get(string $id)
    {
        return static::$instances[$id];
    }

    public function has(string $id): bool
    {
        // TODO: Implement has() method.
        return true;
    }

    public function set(string $id, $concrete): void
    {
        static::$instances[$id] = $concrete;
    }
}
