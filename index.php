<?php

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Issue\IssueService;

require_once 'vendor/autoload.php';

class Jira  {
    public function __construct(private JiraConfigDto $configDto) { }

    public function getJiraActivity(string $startDate):array {
        $jiraClient= new IssueService(new ArrayConfiguration((array)$this->configDto));
        $activities = $jiraClient->search(sprintf($this->configDto->jiraQuery, $startDate),0, $this->configDto->jiraMaxResults);
        $ticketList = array_map(static function (Issue $issue) { return $issue->key; }, $activities->getIssues());

        $jiraActivities = [];
        foreach ($ticketList as $issueKey) {
            $comments = $jiraClient->getComments($issueKey);
            foreach ($comments->comments as $comment) {
                if (date('Y-m-d H:i', strtotime($comment->updated)) >= $startDate
                    && (isset($comment->author->emailAddress) && $comment->author->emailAddress === $this->configDto->jiraUser)) {
                    $jiraActivities[$issueKey][] = $comment;
                }
            }
        }
        return $jiraActivities;
    }
}

class JiraConfigDto { public function __construct(public string $jiraPassword,public string $jiraHost,public string $jiraUser,public string $jiraMaxResults,public string $jiraQuery) { }}
class ForecastConfigDto { public function __construct(public string $forecastHost,public string $forecastApiKey,public string $forecastProjectId,public string $forecastPersonId,public string $forecastFallbackTaskId) { }}

class Forecast {
    private const TASK_LIST_ENDPOINT = '/api/v2/projects/{{PROJECT_ID}}/tasks', TIME_REGISTRATIONS_ENDPOINT = '/api/v1/time_registrations', COMMENT_IDENTIFIER = 'Ticket Bearbeitung: ';
    public static $TASK_CHACHE=[];

    public function __construct(private Client $guzzleClient,private ForecastConfigDto $forecastConfigDto) {
        self::$TASK_CHACHE = $this->callGetApi(str_replace('{{PROJECT_ID}}',$forecastConfigDto->forecastProjectId,self::TASK_LIST_ENDPOINT));
    }

    private function callGetApi(string $path) {
        $res = $this->guzzleClient->request('GET',$path, [
            'headers' => [ 'X-FORECAST-API-KEY' => $this->forecastConfigDto->forecastApiKey ]
        ]);
        return \json_decode($res->getBody(), null, 512, JSON_THROW_ON_ERROR);
    }

    private function callPostApi(string $path, array $postData) {
        $res = $this->guzzleClient->request('POST',$path, [
            'headers' => [ 'X-FORECAST-API-KEY' => $this->forecastConfigDto->forecastApiKey, 'Content-Type' => 'application/json', 'Accept' => 'application/json' ],
            'body' => \json_encode($postData, JSON_THROW_ON_ERROR)
        ]);
        return \json_decode($res->getBody(), null, 512, JSON_THROW_ON_ERROR);
    }

    public function writeTimeRegistrations(array $jiraActivities):void {
        foreach ($jiraActivities as $jiraTicketNr=>$jiraComments) {
            foreach ($jiraComments as $jiraComment) {
                $writeTimeRegistration = ['person'=>(int)$this->forecastConfigDto->forecastPersonId, 'task'=> $this->findTaskIdToNeedle($jiraTicketNr),'time_registered'=>15,'date'=>date('Y-m-d', strtotime($jiraComment->updated)),'notes'=>self::COMMENT_IDENTIFIER. substr(preg_replace('/\[[^)]+\]/','',$jiraComment->body),0,60)];
                $writeResponse = $this->callPostApi(self::TIME_REGISTRATIONS_ENDPOINT, $writeTimeRegistration);
                echo "New Time Entry (date: $writeResponse->date, person: $writeResponse->person, notes: $writeResponse->notes \n";
            }
        }
    }

    public function findTaskIdToNeedle(string $taskNeedle): int {
        foreach (self::$TASK_CHACHE as $task) {
            if (\str_contains($task->title, $taskNeedle)) {
                return $task->id;
            }
        }
        return (int)$this->forecastConfigDto->forecastFallbackTaskId;
    }
}

Dotenv::createImmutable(__DIR__)->load();

$jiraActivities = (new Jira(new JiraConfigDto($_ENV['JIRA_TOKEN'],$_ENV['JIRA_HOST'],$_ENV['JIRA_USER'],$_ENV['JIRA_MAX_RESULTS'],$_ENV['JIRA_QUERY'])))->getJiraActivity(date('Y-m-d 00:00'));
(new Forecast(new Client(['base_uri'=>(string)$_ENV['FORECAST_HOST']]),new ForecastConfigDto($_ENV['FORECAST_HOST'],$_ENV['FORECAST_API_KEY'],$_ENV['FORECAST_PROJECT_ID'],$_ENV['FORECAST_PERSON_ID'],$_ENV['FORECAST_FALLBACK_TASK_ID'])))->writeTimeRegistrations($jiraActivities);

die('done.');
