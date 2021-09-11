[![Minimum PHP version: 8.0.0](https://img.shields.io/badge/php-8.0%2B-blue.svg)](https://github.com/patrickjaja/forecast.it.fill)
[![Continuous Integration](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/php.yml/badge.svg)](https://github.com/patrickjaja/forecast.it.fill/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill?branch=master)

[comment]: <> ([![Infection MSI]&#40;https://img.shields.io/endpoint?url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Finfection%2Finfection%2Fmaster&#41;]&#40;https://infection.github.io&#41;)

[comment]: <> ([![codecov]&#40;https://codecov.io/gh/infection/infection/branch/master/graph/badge.svg&#41;]&#40;https://codecov.io/gh/infection/infection&#41;)

[comment]: <> ([![Slack channel: #infection on the Symfony slack]&#40;https://img.shields.io/badge/slack-%23infection-green.svg?style=flat-square&#41;]&#40;https://symfony.com/slack-invite&#41;)

# Forecast.it activity automation process
### supported activity sources
 - [jira](ForecastAutomation/JiraClient/Shared/Plugin/JiraActivityPlugin.php)
   (will create an activity entry if you comment a ticket)
 - [gitlab](ForecastAutomation/GitlabClient/Shared/Plugin/GitlabActivityPlugin.php)
   (will create an activity if you comment a MR by consuming gitlab event api)
 - [mattermost](ForecastAutomation/MattermostClient/Shared/Plugin/MattermostActivityPlugin.php)
   (will create an activity if you direct message a text that includes a ticketnumber)
### How to use
 - run `php bin/console forecast:import:activity` at the end of the day (date('Y-m-d 00:00') used by default) to fill your forecast.it timesheet with your [enabled activity plugins](ForecastAutomation/Activity/ActivityDependencyProvider.php)

### setup
 - `composer install`
 - create `http-client.local.json` (to get forecast_ids via `forecast_api.http`)
 - create `.env` with your configuration

ToDo:
    - reduce configuration parameters by consuming more api endpoints (i.e. forecast /persons to receive personid)
    - add tests
    - add tooling
    - add github workflow
    - Logging (any open source logging target?)
    - save latest sync state and allow sync everything missed in between
    - allow more than one jira project to be synced to forecast
