<?php

namespace ForecastAutomation\MattermostClient\Shared\Plugin\Filter;

interface ChannelFilterInterface
{
    public function apply(array $channelCollection): array;
}
