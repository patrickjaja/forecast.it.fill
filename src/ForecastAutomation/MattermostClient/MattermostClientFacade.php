<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient;

use ForecastAutomation\Kernel\AbstractFacade;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostChannelFilterQueryDto;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostPostsQueryDto;

/**
 * @method \ForecastAutomation\MattermostClient\MattermostClientFactory getFactory()
 */
class MattermostClientFacade extends AbstractFacade
{
    public function getChannel(MattermostChannelFilterQueryDto $channelFilterQueryDto): array
    {
        return $this->getFactory()->createMattermostApi()->getChannel($channelFilterQueryDto);
    }

    public function getPosts(MattermostPostsQueryDto $mattermostPostsQueryDto): array
    {
        return $this->getFactory()->createMattermostApi()->getPosts($mattermostPostsQueryDto);
    }
}
