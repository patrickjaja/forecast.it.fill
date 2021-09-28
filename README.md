[![Minimum PHP version: 8.0.0](https://img.shields.io/badge/php-8.0%2B-blue.svg)](https://github.com/patrickjaja/forecast.it.fill)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill?branch=master)
[![Scrutinizer Code Coverage](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/patrickjaja/forecast.it.fill?branch=master)
[![Tests](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phptests.yml/badge.svg)](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phptests.yml)
[![phpstan level5](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phpstan.yml/badge.svg)](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phpstan.yml)
[![Arkitect](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phparkitect.yml/badge.svg)](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phparkitect.yml)
[![Deptrac](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phpdeptrac.yml/badge.svg)](https://github.com/patrickjaja/forecast.it.fill/actions/workflows/phpdeptrac.yml)

Forecast.it activity automation process
==========================

This project is used to fill your forecast.it timesheets in a comfortable way.
Enable and configure plugins on your needs and enjoy newly acquired free time.

## Documentation

### ⚡ supported activity sources
 - [jira](src/ForecastAutomation/JiraClient/Shared/Plugin/JiraActivityPlugin.php)
   (will create an activity entry if you [comment](src/ForecastAutomation/JiraClient/Business/JiraCollector.php#L41) a ticket)
 - [gitlab](src/ForecastAutomation/GitlabClient/Shared/Plugin/GitlabActivityPlugin.php)
   (will create an activity if you [comment or approve](src/ForecastAutomation/GitlabClient/Shared/Plugin/GitlabActivityPlugin.php#L25) a MR by consuming gitlab event api)
 - [mattermost](src/ForecastAutomation/MattermostClient/Shared/Plugin/MattermostActivityPlugin.php)
   (will create an activity if you [direct message](src/ForecastAutomation/MattermostClient/Business/MattermostApi.php#L112) a text that [contains a ticketnumber](src/ForecastAutomation/MattermostClient/Shared/Plugin/MattermostActivityPlugin.php#L53))
 - [periodical activity](src/ForecastAutomation/PeriodicalActivityDataImport/Shared/Plugin/PeriodicalActivityDataImportConsoleCommandPlugin.php)
   (will create weekly reapting activities based on [configuration](.env.dist#L29))
### ✨ How to use
 - run `php bin/console forecast:import:activity` at the end of the day (date('Y-m-d 00:00') used by default) to fill your forecast.it timesheet with your [enabled activity plugins](src/ForecastAutomation/Activity/ActivityDependencyProvider.php)

### ⚙️ setup
 - `composer install`
 - create `http-client.local.json` (to get forecast_ids via `forecast_api.http`)
 - create `.env` with your configuration

### ✌️ ToDo:
- https://github.com/patrickjaja/forecast.it.fill/issues

