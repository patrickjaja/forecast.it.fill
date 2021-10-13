<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient\Shared\Plugin\Filter;

use DateTime;

class HasMessageChannelFilter implements ChannelFilterInterface
{
//    public function __construct(private DateTime $lastPostDateTime)
//    {
//    }

    public function apply(array $channelCollection): array
    {
        //ToDo: move new \DateTime(date('Y-m-d')) to configuration or db
        $filteredChannel = [];
        foreach ($channelCollection as $channel) {
            if ($channel->total_msg_count > 0
                && $channel->last_post_at >= ((int) (DateTime::createFromFormat('Y-m-d H:i','2021-10-11 00:00'))->format('U') * 1000)) {
//                && $channel->last_post_at >= ((int) (new \DateTime(date('Y-m-d')))->format('U') * 1000)) {
                $filteredChannel[] = $channel;
            }
        }

        return $filteredChannel;
    }
}
