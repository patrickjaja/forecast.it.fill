<?php

namespace ForecastAutomation\ForecastClient\Business;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\Shared\Dto\ForecastConfigDto;
use GuzzleHttp\Client;

class ForecastApi
{
    private const TASK_LIST_ENDPOINT = '/api/v2/projects/{{PROJECT_ID}}/tasks', TIME_REGISTRATIONS_ENDPOINT = '/api/v1/time_registrations', COMMENT_IDENTIFIER = 'Ticket Bearbeitung: ';

    public static $TASK_CHACHE = [];

    public function __construct(private Client $guzzleClient, private ForecastConfigDto $forecastConfigDto)
    {
        self::$TASK_CHACHE = $this->callGetApi(
            str_replace('{{PROJECT_ID}}', $forecastConfigDto->forecastProjectId, self::TASK_LIST_ENDPOINT)
        );
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

    public function writeActivities(ActivityDtoCollection $activityDtoCollection): void
    {
        foreach ($activityDtoCollection as $activityDto) {
            $writeTimeRegistration = [
                'person' => (int)$this->forecastConfigDto->forecastPersonId,
                'task' => $this->findTaskIdToNeedle($activityDto->needle),
                'time_registered' => 15,
                'date' => $activityDto->updated->format('Y-m-d'),
                'notes' => self::COMMENT_IDENTIFIER . substr(preg_replace('/\[[^)]+\]/', '', $activityDto->description), 0, 60),
            ];
            $writeResponse = $this->callPostApi(self::TIME_REGISTRATIONS_ENDPOINT, $writeTimeRegistration);
            echo "New Time Entry (date: $writeResponse->date, person: $writeResponse->person, notes: $writeResponse->notes \n";
        }
    }

    private function findTaskIdToNeedle(string $taskNeedle): int
    {
        foreach (self::$TASK_CHACHE as $task) {
            if (\str_contains($task->title, $taskNeedle)) {
                return $task->id;
            }
        }

        return (int)$this->forecastConfigDto->forecastFallbackTaskId;
    }
}
