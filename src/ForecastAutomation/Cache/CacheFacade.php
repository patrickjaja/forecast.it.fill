<?php

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Cache;

use ForecastAutomation\Kernel\AbstractFacade;
use Shieldon\SimpleCache\Cache;

/**
 * @method \ForecastAutomation\Cache\CacheFactory getFactory()
 */
class CacheFacade extends AbstractFacade
{
    public function get($key, $default = null): mixed
    {
        //ToDo: Move str_replace to Business + add cache disable option means has = always false
        return $this->getFactory()->createSimpleCache()->get(\str_replace('/', '', $key), $default);
    }

    public function has($key): bool
    {
        return $this->getFactory()->createSimpleCache()->has(\str_replace('/', '', $key));
    }

    public function set($key, $value, $ttl = 600): bool
    {
        return $this->getFactory()->createSimpleCache()->set(\str_replace('/', '', $key), $value, $ttl);
    }
}
