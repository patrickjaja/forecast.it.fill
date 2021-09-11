[![Minimum PHP version: 8.0.0](https://img.shields.io/badge/php-8.0%2B-blue.svg)](https://github.com/patrickjaja/forecast.it.fill)
[![Continuous Integration](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/php.yml/badge.svg)](https://github.com/patrickjaja/forecast.it.fill/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill?branch=master)
[![Scrutinizer Code Coverage](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill?branch=master)

[comment]: <> ([![codecov]&#40;https://codecov.io/gh/infection/infection/branch/master/graph/badge.svg&#41;]&#40;https://codecov.io/gh/infection/infection&#41;)

# Forecast.it activity automation process
### ⚡ supported activity sources
 - [jira](src/ForecastAutomation/JiraClient/Shared/Plugin/JiraActivityPlugin.php)
   (will create an activity entry if you comment a ticket)
 - [gitlab](src/ForecastAutomation/GitlabClient/Shared/Plugin/GitlabActivityPlugin.php)
   (will create an activity if you comment a MR by consuming gitlab event api)
 - [mattermost](src/ForecastAutomation/MattermostClient/Shared/Plugin/MattermostActivityPlugin.php)
   (will create an activity if you direct message a text that includes a ticketnumber)
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
- Logging (any open source logging target?)
- extract Kernel (find project name)
- save latest sync state and allow sync everything missed in between
- allow more than one jira project to be synced to forecast
