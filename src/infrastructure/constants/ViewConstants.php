<?php

namespace omarinina\infrastructure\constants;

class ViewConstants
{
    public const PAGE_COUNTER = 5;
    public const BUTTON_COUNT_PAGINATION = 3;

    public const CLIENT_TASK_FILTER_TITLES = [
        null => TaskStatusConstants::NAME_NEW_STATUS,
        TaskStatusConstants::ID_NEW_STATUS => TaskStatusConstants::NAME_NEW_STATUS,
        TaskStatusConstants::ID_IN_WORK_STATUS => TaskStatusConstants::NAME_IN_WORK_STATUS,
        TaskStatusConstants::ID_DONE_STATUS => TaskStatusConstants::NAME_DONE_STATUS
    ];

    public const EXECUTOR_TASK_FILTER_TITLES = [
        null => TaskStatusConstants::NAME_IN_WORK_STATUS,
        TaskStatusConstants::ID_IN_WORK_STATUS => TaskStatusConstants::NAME_IN_WORK_STATUS,
        TaskStatusConstants::ID_OVERDUE_STATUS => TaskStatusConstants::NAME_OVERDUE_STATUS,
        TaskStatusConstants::ID_DONE_STATUS => TaskStatusConstants::NAME_DONE_STATUS
    ];

    public const DEFAULT_AVATARS = [
        '/img/avatars/1.png',
        '/img/avatars/2.png',
        '/img/avatars/3.png',
        '/img/avatars/4.png',
        '/img/avatars/5.png'
    ];
}
