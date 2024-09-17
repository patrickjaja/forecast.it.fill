<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ProjektronClient\Business;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;

class ProjektronApi
{
    private string $csrf;

    public function __construct(
        private string $projektronApiEndpoint,
        private string $projektronCookieHeaderValue,
        private string $username,
        private string $catchAllTask
    ) { $this->setCsrfFromCookie();  }

    public function writeActivities(ActivityDtoCollection $activityDtoCollection): int
    {
        $savedActivities = 0;
        foreach ($activityDtoCollection as $activityDto) {
            $activityDto->needle = $this->setCatchAllOnUnknownTask($activityDto->needle);
            $activityDto->created->sub(new \DateInterval('P1D')); // give projektron a date, and it adds +1 day, so remove one day of the time entry, HAHAHA
            $activityDto->created->setTime(22, 0, 0); // projektron doesnt save the entry if the time is not 22:00 HAHAHA
            $payloadDto = new PayloadDto(
                $activityDto->needle,
                $this->csrf,$this->username,
                $activityDto->created->getTimestamp().'000',
                (string)intdiv($activityDto->duration, 60),
                (string)($activityDto->duration%60),
                $activityDto->description
            );
            $this->sendActivity($this->projektronApiEndpoint.'?oid='.$activityDto->needle, $payloadDto);
            ++$savedActivities;
        }

        return $savedActivities;
    }

    private function sendActivity(string $path, PayloadDto $payloadDto): string
    {
        $this->headers = [
            'Cookie: '.$this->projektronCookieHeaderValue,
            'User-Agent: ArchUser/1337',
        ];

        $ch = curl_init($path);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadDto->getEncodedData());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (!$this->isProjektronActivitySuccess($response)) {
            throw new \Exception('Could not send activity to projektron.');
        }

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);

        return $response;
    }

    private function isProjektronActivitySuccess(string $response): bool
    {
        return strpos($response, '<div class="msg affirmation">') !== false;
    }

    private function setCsrfFromCookie() {
        $pattern = '/CSRF_Token=([^;]+)/';
        if (preg_match($pattern, $this->projektronCookieHeaderValue, $matches)) {
            $this->csrf = $matches[1];
        } else {
            new \Exception('Projektron API error. CSRF_Token not found in cookie header.');
        }
    }

    private function setCatchAllOnUnknownTask(string $projektronTaskId):string {
        if (\strpos($projektronTaskId, '_JTask') === false) {
            return $this->catchAllTask;
        } else {
            return $projektronTaskId;
        }
    }
}
