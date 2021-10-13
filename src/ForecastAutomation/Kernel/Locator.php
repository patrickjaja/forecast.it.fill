<?php

declare(strict_types = 1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Kernel;

use ReflectionClass;

class Locator
{
    private array $callerClassParts;
    public static $container = null;

    /**
     * @var static
     */
    private static $instance;

    public function __construct(object $callerClass)
    {
        $this->callerClassParts = explode('\\', ltrim(\get_class($callerClass), '\\'));
    }

    public function __call($name, $arguments): void
    {
        // bla, bla testen
        echo "Rufe die Objektmethode '{$name}' "
            . implode(', ', $arguments) . "\n";
    }

    public function getFacade(): object
    {
        return $this->resolve(KernelConfig::MODULE_FACADE);
    }

    public function getFactory(): object
    {
        return $this->resolve(KernelConfig::MODULE_FACTORY);
    }

    public function getProvidedDependency(string $id)
    {
        return $this->resolve(KernelConfig::MODULE_DEPENDENCY_PROVIDER)->get($id);
    }

    private function resolve(string $type): object
    {
        $reflector = new ReflectionClass(
            sprintf(
                $type,
                $this->callerClassParts[KernelConfig::NAMESPACE_CLASSNAME_POSITION],
                $this->callerClassParts[KernelConfig::BUNDLE_CLASSNAME_POSITION],
                $this->callerClassParts[KernelConfig::BUNDLE_CLASSNAME_POSITION]
            )
        );

        return $reflector->newInstance();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function getRepository(): object
    {
        return $this->resolve(KernelConfig::MODULE_REPOSITORY);
    }
}
