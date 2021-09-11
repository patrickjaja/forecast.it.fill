<?php

namespace ForecastAutomation\ForecastClient\Business;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\Shared\Dto\ForecastConfigDto;
use GuzzleHttp\Client;

class ForecastApi
{
    private const TASK_LIST_ENDPOINT = '/api/v2/projects/{{PROJECT_ID}}/tasks', TIME_REGISTRATIONS_ENDPOINT = '/api/v1/time_registrations';

    public static array $TASK_CACHE = [];

    public function __construct(private Client $guzzleClient, private ForecastConfigDto $forecastConfigDto)
    {
        //ToDo: Use \Psr\SimpleCache\CacheInterface $this->cache->set($cacheKey, $result, 6000)
        $this->warmTaskCache();
    }

    private function warmTaskCache(): array
    {
        if (count(static::$TASK_CACHE) === 0) {
            static::$TASK_CACHE = $this->callGetApi(
                str_replace('{{PROJECT_ID}}', $this->forecastConfigDto->forecastProjectId, self::TASK_LIST_ENDPOINT)
            );
        }

        return static::$TASK_CACHE;
    }

    private function callGetApi(string $path)
    {
        $res = $this->guzzleClient->request(
            'GET',
            $path,
            [
                'headers' => ['X-FORECAST-API-KEY' => $this->forecastConfigDto->forecastApiKey],
            ]
        );

        return \json_decode($res->getBody(), null, 512, JSON_THROW_ON_ERROR);
    }

    private function callPostApi(string $path, array $postData)
    {
        $res = $this->guzzleClient->request(
            'POST',
            $path,
            [
                'headers' => [
                    'X-FORECAST-API-KEY' => $this->forecastConfigDto->forecastApiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'body' => \json_encode($postData, JSON_THROW_ON_ERROR),
            ]
        );

        return \json_decode($res->getBody(), null, 512, JSON_THROW_ON_ERROR);
    }

    public function writeActivities(ActivityDtoCollection $activityDtoCollection): int
    {
        $savedActivities = 0;
        foreach ($activityDtoCollection as $activityDto) {
            $writeTimeRegistration = [
                'person' => (int)$this->forecastConfigDto->forecastPersonId,
                'task' => $this->findTaskIdToNeedle($activityDto->needle),
                'time_registered' => $activityDto->duration,
                'date' => $activityDto->created->format('Y-m-d'),
                'notes' => $activityDto->description,
            ];
            $writeResponse = $this->callPostApi(self::TIME_REGISTRATIONS_ENDPOINT, $writeTimeRegistration);
            //ToDo: return output or use loggertrait, otherwise not testable
//            echo "New Time Entry (date: $writeResponse->date, person: $writeResponse->person, notes: $writeResponse->notes \n";
            $savedActivities++;
        }

        return $savedActivities;
    }

    private function findTaskIdToNeedle(string $taskNeedle): int
    {
        foreach (static::$TASK_CACHE as $task) {
            if (\str_contains($task->title, $taskNeedle)) {
                return $task->id;
            }
        }

        return (int)$this->forecastConfigDto->forecastFallbackTaskId;
    }
}
