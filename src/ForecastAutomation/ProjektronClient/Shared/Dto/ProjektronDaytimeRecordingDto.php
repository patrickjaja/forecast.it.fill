<?php

class ProjektronDaytimeRecordingDto
{
    public string $componentTitleComposed;
    public bool $formSubmitted;
    public string $dataFirstOnPage;
    public bool $dialogGroupVisibleOptions;
    public string $settingsBoardColumnContent0EditorType;
    public string $settingsBoardColumnContent0AvailableTokens;
    public string $settingsBoardColumnContent0;
    public string $settingsBoardColumnContent0Search;
    public bool $settingsDialogOpened;
    public bool $filtersHasUnappliedChanges;
    public ?int $selectionsEffortRecordingDateYear;
    public ?int $selectionsEffortRecordingDateMonth;
    public ?int $selectionsEffortRecordingDateDay;
    public string $selectionsEffortRecordingDateCalendarState;
    public string $selectionsEffortRecordingDateCalendarAttribute;
    public string $contentSingleEffortTaskSelectorFixedTaskDataCustomTitle;
    public string $contentSingleEffortTaskSelectorFixedTaskDataFirstOnPage;
    public string $contentSingleEffortTaskSelectorFixedTaskTask;
    public string $contentSingleEffortTaskSelectorFixedTaskTaskEntityName;
    public string $contentSingleEffortTaskSelectorFixedTaskSelectedTaskSummaryDataFirstOnPage;
    public bool $contentSingleEffortTaskSelectorFixedTaskSelectedTaskSummaryDataSuppressLastHorizontalLine;
    public bool $contentSingleEffortTaskSelectorFixedTaskEditFormDataSubmitted;
    public string $contentSingleEffortEffortEditorEffort1DataFirstOnPage;
    public bool $contentSingleEffortEffortEditorEffort1DataSuppressLastHorizontalLine;
    public string $contentSingleEffortEffortEditorEffort1Oid;
    public string $contentSingleEffortEffortEditorEffort1EditorType;
    public int $contentSingleEffortEffortEditorEffort1Effort;
    public string $contentSingleEffortEffortEditorEffort1EffortDate;
    public string $contentSingleEffortEffortEditorEffort1EffortDateEditorType;
    public string $contentSingleEffortEffortEditorEffort1StartTime;
    public string $contentSingleEffortEffortEditorEffort1StartTimeEditorType;
    public string $contentSingleEffortEffortEditorEffort1EndTime;
    public string $contentSingleEffortEffortEditorEffort1EndTimeEditorType;
    public ?string $contentSingleEffortEffortEditorEffort1Note;
    public string $contentSingleEffortEffortEditorEffort1NoteEditorType;
    public bool $contentSingleEffortEffortEditorEffort1EditFormDataSubmitted;
    public string $contentSingleEffortGeneralEffortDataFirstOnPage;
    public bool $contentSingleEffortGeneralEffortDataSuppressLastHorizontalLine;
    public bool $contentSingleEffortGeneralEffortEditFormDataSubmitted;
    public string $viewState;


    public function buildPostData(ProjektronDaytimeRecordingDto $dto): string
    {
        $data = [
            'daytimerecording,__componentTitleComposed' => $dto->componentTitleComposed,
            'daytimerecording,formsubmitted' => $dto->formSubmitted ? 'true' : 'false',
            'daytimerecording,Data_FirstOnPage' => $dto->dataFirstOnPage,
            'daytimerecording,dialog_group_visible_options' => $dto->dialogGroupVisibleOptions ? 'true' : 'false',
            'daytimerecording,Settings,SettingsDefinitions,DisplayOptions,boardColumnContent0,boardColumnContent0_editortype' => $dto->settingsBoardColumnContent0EditorType,
            'daytimerecording,Settings,SettingsDefinitions,DisplayOptions,boardColumnContent0,boardColumnContent0_availableTokens' => $dto->settingsBoardColumnContent0AvailableTokens,
            'daytimerecording,Settings,SettingsDefinitions,DisplayOptions,boardColumnContent0,boardColumnContent0' => $dto->settingsBoardColumnContent0,
            'daytimerecording,Settings,SettingsDefinitions,DisplayOptions,boardColumnContent0,boardColumnContent0_search' => $dto->settingsBoardColumnContent0Search,
            'daytimerecording,settings_dialog_opened' => $dto->settingsDialogOpened ? 'false' : 'true',
            'daytimerecording,filters_has_unapplied_changes' => $dto->filtersHasUnappliedChanges ? 'true' : 'false',
            'daytimerecording,Selections,effortRecordingDate,year' => $dto->selectionsEffortRecordingDateYear,
            'daytimerecording,Selections,effortRecordingDate,month' => $dto->selectionsEffortRecordingDateMonth,
            'daytimerecording,Selections,effortRecordingDate,day' => $dto->selectionsEffortRecordingDateDay,
            'daytimerecording,Selections,effortRecordingDate,__calendar_state' => $dto->selectionsEffortRecordingDateCalendarState,
            'daytimerecording,Selections,effortRecordingDate,__calendarattribute' => $dto->selectionsEffortRecordingDateCalendarAttribute,
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,Data_CustomTitle' => $dto->contentSingleEffortTaskSelectorFixedTaskDataCustomTitle,
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,Data_FirstOnPage' => $dto->contentSingleEffortTaskSelectorFixedTaskDataFirstOnPage,
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,task,task' => $dto->contentSingleEffortTaskSelectorFixedTaskTask,
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,task,task_entityname' => $dto->contentSingleEffortTaskSelectorFixedTaskTaskEntityName,
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,selectedTaskSummary,selectedTaskSummaryWithInterval,Data_FirstOnPage' => $dto->contentSingleEffortTaskSelectorFixedTaskSelectedTaskSummaryDataFirstOnPage,
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,selectedTaskSummary,selectedTaskSummaryWithInterval,Data_SuppressLastHorizontalLine' => $dto->contentSingleEffortTaskSelectorFixedTaskSelectedTaskSummaryDataSuppressLastHorizontalLine ? 'true' : 'false',
            'daytimerecording,Content,singleeffort,TaskSelector,fixedtask,edit_form_data_submitted' => $dto->contentSingleEffortTaskSelectorFixedTaskEditFormDataSubmitted ? 'true' : 'false',
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,Data_FirstOnPage' => $dto->contentSingleEffortEffortEditorEffort1DataFirstOnPage,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,Data_SuppressLastHorizontalLine' => $dto->contentSingleEffortEffortEditorEffort1DataSuppressLastHorizontalLine ? 'true' : 'false',
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,oid' => $dto->contentSingleEffortEffortEditorEffort1Oid,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effort_editortype' => $dto->contentSingleEffortEffortEditorEffort1EditorType,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effort' => $dto->contentSingleEffortEffortEditorEffort1Effort,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effort_date' => $dto->contentSingleEffortEffortEditorEffort1EffortDate,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,effort_date_editortype' => $dto->contentSingleEffortEffortEditorEffort1EffortDateEditorType,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,start_time' => $dto->contentSingleEffortEffortEditorEffort1StartTime,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,start_time_editortype' => $dto->contentSingleEffortEffortEditorEffort1StartTimeEditorType,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,end_time' => $dto->contentSingleEffortEffortEditorEffort1EndTime,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,end_time_editortype' => $dto->contentSingleEffortEffortEditorEffort1EndTimeEditorType,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,note' => $dto->contentSingleEffortEffortEditorEffort1Note,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,note_editortype' => $dto->contentSingleEffortEffortEditorEffort1NoteEditorType,
            'daytimerecording,Content,singleeffort,EffortEditor,effort1,edit_form_data_submitted' => $dto->contentSingleEffortEffortEditorEffort1EditFormDataSubmitted ? 'true' : 'false',
            'daytimerecording,Content,singleeffort,generalEffort,Data_FirstOnPage' => $dto->contentSingleEffortGeneralEffortDataFirstOnPage,
            'daytimerecording,Content,singleeffort,generalEffort,Data_SuppressLastHorizontalLine' => $dto->contentSingleEffortGeneralEffortDataSuppressLastHorizontalLine ? 'true' : 'false',
            'daytimerecording,Content,singleeffort,generalEffort,edit_form_data_submitted' => $dto->contentSingleEffortGeneralEffortEditFormDataSubmitted ? 'true' : 'false',
            'javax.faces.ViewState' => $dto->viewState,
        ];

        return http_build_query($data);
    }
}


