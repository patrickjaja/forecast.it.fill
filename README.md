# create forecast.it time entries based on jira comments
 - run at the end of the day (date('Y-m-d 00:00') used by default) to fill your forecast.it timesheet

# getting started
 - `composer install`
 - create `http-client.local.json` (to get forecast_ids via `forecast_api.http`) and fill in `.env` values
 - run with cli `php index.php`


ToDo:
 - Logging
 - allow more than one jira project to be synced to forecast
 - add tests
 - add tooling
 - add github workflow
