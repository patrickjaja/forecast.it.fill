<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient\Shared\Plugin\Filter;

class IsDirectChannelFilter implements ChannelFilterInterface
{
    public function apply(array $channelCollection): array
    {
        $filteredChannel = [];
        foreach ($channelCollection as $channel) {
            if ('D' === $channel->type) {
                $filteredChannel[] = $channel;
            }
        }

        return $filteredChannel;
    }
}
