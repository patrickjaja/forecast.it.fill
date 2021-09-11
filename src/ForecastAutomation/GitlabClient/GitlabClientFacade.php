<?php

namespace ForecastAutomation\GitlabClient;

use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
use ForecastAutomation\Kernel\AbstractFacade;

/**
 * @method \ForecastAutomation\GitlabClient\GitlabClientFactory getFactory()
 */
class GitlabClientFacade extends AbstractFacade
{
    public function getEvents(GitlabQueryDto $gitlabQueryDto): array
    {
        return $this->getFactory()->createGitlabApi()->getEvents($gitlabQueryDto);
    }
}
