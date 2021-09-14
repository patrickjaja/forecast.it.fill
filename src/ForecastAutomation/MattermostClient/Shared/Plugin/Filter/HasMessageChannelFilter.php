<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient\Shared\Plugin\Filter;

use DateTime;

class HasMessageChannelFilter implements ChannelFilterInterface
{
    public function __construct(private DateTime $lastPostDateTime)
    {
    }

    /**
     * @return \DateTime
     */
    public function apply(array $channelCollection): array
    {
        $filteredChannel = [];
        foreach ($channelCollection as $channel) {
            if ($channel->total_msg_count > 0
                && $channel->last_post_at >= ((int) $this->lastPostDateTime->format('U') * 1000)) {
                $filteredChannel[] = $channel;
            }
        }

        return $filteredChannel;
    }
}
