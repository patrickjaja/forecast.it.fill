<?php

namespace ForecastAutomation\MattermostClient;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
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
    public function getPosts(MattermostPostsQueryDto $mattermostPostsQueryDto): \stdClass
    {
        return $this->getFactory()->createMattermostApi()->getPosts($mattermostPostsQueryDto);
    }
}
