<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient;

use ForecastAutomation\Kernel\AbstractFacade;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostPostsQueryDto;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * @method \ForecastAutomation\MattermostClient\MattermostClientFactory getFactory()
 */
class MattermostClientFacade extends AbstractFacade
{
    public function getChannel(array $channelFilterCollection): PromiseInterface
    {
        return $this->getFactory()->createMattermostApi()->getChannel($channelFilterCollection);
    }

    public function getPosts(MattermostPostsQueryDto $mattermostPostsQueryDto): PromiseInterface
    {
        return $this->getFactory()->createMattermostApi()->getPosts($mattermostPostsQueryDto);
    }
}
