<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\GitlabClient;

use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
use ForecastAutomation\Kernel\AbstractFacade;

class GitlabClientFacade extends AbstractFacade
{
    public function __construct(private GitlabClientFactory $gitlabClientFactory)
    {
    }

    public function getEvents(GitlabQueryDto $gitlabQueryDto): array
    {
        return $this->gitlabClientFactory->createGitlabApi()->getEvents($gitlabQueryDto);
    }
}
