# create forecast.it time entries based on jira comments
 - run at the end of the day (since its date('Y-m-d 00:00') per default) to fill your forecast.it timesheet

# getting started
 - `composer install`
 - create `http-client.local.json` (to get forecast_ids via `forecast_api.http`) and fill in `.env` values
 - run with cli `php index.php`


ToDo:
 - Logging
