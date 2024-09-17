<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ProjektronClient\Business;

class PayloadDto {
    private $data;

    public function __construct(string $task, string $csrfToken, string $username, string $day, string $hours, string $minutes, string $description) {
        $this->data = [
            'daytimerecording,formsubmitted' => 'true',
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,Data_CustomTitle' => 'Einzelbuchen',
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,Data_FirstOnPage' => 'daytimerecording',
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,Data_FirstOnPage' => 'daytimerecording',
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,task,task' => $task, // task
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effortStart,effortStart_hour' => '',
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effortStart,effortStart_minute' => '',
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effortEnd,effortEnd_hour' => '',
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effortEnd,effortEnd_minute' => '',
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effortExpense,effortExpense_hour' => $hours,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effortExpense,effortExpense_minute' => $minutes,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,description,description' => $description,
            'daytimerecording,Content,singleeffort,recordType' => 'neweffort',
            'daytimerecording,Content,singleeffort,recordOid' => '',
            'daytimerecording,Content,singleeffort,recordDate' => $day, // day
            'daytimerecording,editableComponentNames' => 'daytimerecording,Content,singleeffort daytimerecording,Content,daytimerecordingAllBookingsOfTheDay',
            'oid' => $task,
            'user' => $username,
            'action,MultiComponentDayTimeRecordingAction,daytimerecording' => '0',
            'BCS.ConfirmDiscardChangesDialog,InitialApplyButtonsOnError' => 'daytimerecording,Apply',
            'CSRF_Token' => $csrfToken,
            'daytimerecording,Apply' => 'daytimerecording,Apply',
            'submitButtonPressed' => 'daytimerecording,Apply',
        ];
    }

    public function getEncodedData() {
        // URL-encode the data for the POST request
        return http_build_query($this->data);
    }
}
