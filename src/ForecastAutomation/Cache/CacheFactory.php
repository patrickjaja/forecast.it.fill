<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Cache;

use ForecastAutomation\Kernel\AbstractFactory;
use Shieldon\SimpleCache\Cache;

class CacheFactory extends AbstractFactory
{
    public function createSimpleCache(): Cache
    {
        if (! file_exists('/tmp/simple-cache')
            && ! mkdir('/tmp/simple-cache', 0777, true)
            && ! is_dir(
                '/tmp/simple-cache'
            )) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', '/tmp/simple-cache'));
        }

        return new Cache(
            $this->getCacheType(),
            [
                'storage' => '/tmp/simple-cache',
            ]
        );
    }

    public function getCacheType(): string
    {
        return 'file';
    }
}
