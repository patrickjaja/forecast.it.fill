# create forecast.it time entries based on jira comments
 - run `php bin/console forecast:import:activity` at the end of the day (date('Y-m-d 00:00') used by default) to fill your forecast.it timesheet with your jira activity

# setup
 - `composer install`
 - create `http-client.local.json` (to get forecast_ids via `forecast_api.http`)
 - create `.env` with your configuration

ToDo:
 - Logging
 - allow more than one jira project to be synced to forecast
 - add tests
 - add tooling
 - add github workflow
