<?php

namespace ForecastAutomation\Kernel;

use ReflectionClass;

class Locator
{
    private array $callerClassParts;

    public function __construct(object $callerClass) { $this->callerClassParts = explode('\\', ltrim(get_class($callerClass), '\\')); }

    public function __call($name, $arguments)
    {
        // bla, bla testen
        echo "Rufe die Objektmethode '$name' "
            . implode(', ', $arguments). "\n";
    }

    public function getFacade():object {
        return $this->resolve(KernelConfig::MODULE_FACADE);
    }

    public function getFactory():object {
        return $this->resolve(KernelConfig::MODULE_FACTORY);
    }

    public function getProvidedDependency(string $id) {
        return $this->resolve(KernelConfig::MODULE_DEPENDENCY_PROVIDER)->get($id);
    }

    private function resolve(string $type): object {
        $reflector = new ReflectionClass(sprintf($type, $this->callerClassParts[KernelConfig::NAMESPACE_CLASSNAME_POSITION], $this->callerClassParts[KernelConfig::BUNDLE_CLASSNAME_POSITION], $this->callerClassParts[KernelConfig::BUNDLE_CLASSNAME_POSITION]));
        return $reflector->newInstance();
    }
}
