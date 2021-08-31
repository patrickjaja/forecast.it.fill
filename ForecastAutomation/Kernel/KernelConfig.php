<?php

namespace ForecastAutomation\Kernel;

class KernelConfig
{
    public const MODULE_FACADE = '\\%s\\%s\\%sFacade';
    public const MODULE_FACTORY = '\\%s\\%s\\%sFactory';
    public const MODULE_DEPENDENCY_PROVIDER = '\\%s\\%s\\%sDependencyProvider';
    public const NAMESPACE_CLASSNAME_POSITION = 0;
    public const BUNDLE_CLASSNAME_POSITION = 1;

    /**
     * @api
     *
     * @return string[]
     */
    public function getApplicationNamespace(): array
    {
        return getenv('APPLICATION_NAMESPACE');
    }
}
