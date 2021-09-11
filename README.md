[![Minimum PHP version: 8.0.0](https://img.shields.io/badge/php-8.0%2B-blue.svg)](https://github.com/patrickjaja/forecast.it.fill)
[![Tests](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phptests.yml/badge.svg)](https://github.com/patrickjaja/forecast.it.fill/actions)
[![phpstan level5](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phpstan.yml/badge.svg)](https://github.com/patrickjaja/forecast.it.fill/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill?branch=master)
[![Scrutinizer Code Coverage](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill?branch=master)

[comment]: <> ([![codecov]&#40;https://codecov.io/gh/infection/infection/branch/master/graph/badge.svg&#41;]&#40;https://codecov.io/gh/infection/infection&#41;)

# Forecast.it activity automation process
### ⚡ supported activity sources
 - [jira](src/ForecastAutomation/JiraClient/Shared/Plugin/JiraActivityPlugin.php)
   (will create an activity entry if you [comment](src/ForecastAutomation/JiraClient/Business/JiraCollector.php#L41) a ticket)
 - [gitlab](src/ForecastAutomation/GitlabClient/Shared/Plugin/GitlabActivityPlugin.php)
   (will create an activity if you [comment or approve](src/ForecastAutomation/GitlabClient/Shared/Plugin/GitlabActivityPlugin.php#L25) a MR by consuming gitlab event api)
 - [mattermost](src/ForecastAutomation/MattermostClient/Shared/Plugin/MattermostActivityPlugin.php)
   (will create an activity if you [direct message](src/ForecastAutomation/MattermostClient/Business/MattermostApi.php#L112) a text that [contains a ticketnumber](src/ForecastAutomation/MattermostClient/Shared/Plugin/MattermostActivityPlugin.php#L53))
### ✨ How to use
 - run `php bin/console forecast:import:activity` at the end of the day (date('Y-m-d 00:00') used by default) to fill your forecast.it timesheet with your [enabled activity plugins](src/ForecastAutomation/Activity/ActivityDependencyProvider.php)

### ⚙️ setup
 - `composer install`
 - create `http-client.local.json` (to get forecast_ids via `forecast_api.http`)
 - create `.env` with your configuration

### ✌️ ToDo:
- reduce configuration parameters by consuming more api endpoints (i.e. forecast /persons to receive personid)
- add tests
- add tooling
- add github workflow
- move direct channel filter to dto
- Logging (any open source logging target?)
- extract Kernel (find project name)
- save latest sync state and allow sync everything missed in between
- allow more than one jira project to be synced to forecast
