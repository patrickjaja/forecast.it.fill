<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Cache;

use ForecastAutomation\Kernel\AbstractFacade;
use Shieldon\SimpleCache\Cache;

class CacheFacade extends AbstractFacade
{
    public function __construct(private CacheFactory $cacheFactory)
    {
    }

    public function get($key, $default = null): mixed
    {
        //ToDo: Move str_replace to Business + add cache disable option means has = always false
        return $this->cacheFactory->createSimpleCache()->get(\str_replace('/', '', $key), $default);
    }

    public function has($key): bool
    {
        return $this->cacheFactory->createSimpleCache()->has(\str_replace('/', '', $key));
    }

    public function set($key, $value, $ttl = 600): bool
    {
        return $this->cacheFactory->createSimpleCache()->set(\str_replace('/', '', $key), $value, $ttl);
    }
}
