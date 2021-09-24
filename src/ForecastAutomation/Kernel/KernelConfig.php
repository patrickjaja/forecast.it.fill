<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Kernel;

class KernelConfig
{
    public const MODULE_FACADE = '\\%s\\%s\\%sFacade';
    public const MODULE_FACTORY = '\\%s\\%s\\%sFactory';
    public const MODULE_DEPENDENCY_PROVIDER = '\\%s\\%s\\%sDependencyProvider';
    public const NAMESPACE_CLASSNAME_POSITION = 0;
    public const BUNDLE_CLASSNAME_POSITION = 1;
}
