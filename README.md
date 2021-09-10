# Forecast.it activity automation process
### supported activity sources
 - [jira](ForecastAutomation/Jira/Shared/Plugin/JiraActivityPlugin.php)
   (will create an activity entry if you comment a ticket)
 - [gitlab](ForecastAutomation/GitlabClient/Shared/Plugin/GitlabActivityPlugin.php)
   (will create an activity if you comment a MR by consuming gitlab event api)
 - [mattermost](ForecastAutomation/MattermostClient/Shared/Plugin/MattermostActivityPlugin.php)
   (will create an activity if you direct message a text that includes a ticketnumber)
### How to use
 - run `php bin/console forecast:import:activity` at the end of the day (date('Y-m-d 00:00') used by default) to fill your forecast.it timesheet with your enabled activity plugins

### setup
 - `composer install`
 - create `http-client.local.json` (to get forecast_ids via `forecast_api.http`)
 - create `.env` with your configuration

ToDo:
    - rename Jira to JiraClient
    - reduce configuration parameters by consuming more api endpoints (i.e. forecast /persons to receive personid)
    - add tests
    - add tooling
    - add github workflow
    - Logging (any open source logging target?)
    - save latest sync state and allow sync everything missed in between
    - allow more than one jira project to be synced to forecast
