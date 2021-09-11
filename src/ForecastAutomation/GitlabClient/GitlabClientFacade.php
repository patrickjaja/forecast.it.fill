<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
