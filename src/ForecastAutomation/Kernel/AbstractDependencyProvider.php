<?php

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

    public function set(string $id, $concrete)
    {
        static::$instances[$id] = $concrete;
    }
}
