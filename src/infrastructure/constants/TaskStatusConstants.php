<?php

declare(strict_types=1);

namespace omarinina\infrastructure\constants;

class TaskStatusConstants
{
    public const ID_NEW_STATUS = 1;
    public const ID_CANCELLED_STATUS = 2;
    public const ID_IN_WORK_STATUS = 3;
    public const ID_DONE_STATUS = 4;
    public const ID_FAILED_STATUS = 5;
    public const ID_OVERDUE_STATUS = 6;

    public const NEW_STATUS = 'new';
    public const CANCELLED_STATUS = 'cancelled';
    public const IN_WORK_STATUS = 'in work';
    public const DONE_STATUS = 'done';
    public const FAILED_STATUS = 'failed';

    public const NAME_NEW_STATUS = 'Новые';
    public const NAME_CANCELLED_STATUS = 'Отмененные';
    public const NAME_IN_WORK_STATUS = 'В процессе';
    public const NAME_DONE_STATUS = 'Закрытые';
    public const NAME_FAILED_STATUS = 'Проваленные';
    public const NAME_OVERDUE_STATUS = 'Просрочено';


    public const CLIENT_TASK_FILTERS = [
        [
            'name' => self::NAME_NEW_STATUS,
            'url' => 'tasks/mine', 'status' => self::ID_NEW_STATUS
        ],
        [
            'name' => self::NAME_IN_WORK_STATUS,
            'url' => 'tasks/mine', 'status' => self::ID_IN_WORK_STATUS
        ],
        [
            'name' => self::NAME_DONE_STATUS,
            'url' => 'tasks/mine', 'status' => self::ID_DONE_STATUS
        ]
    ];

    public const EXECUTOR_TASK_FILTERS = [
        [
            'name' => self::NAME_IN_WORK_STATUS,
            'url' => 'tasks/mine', 'status' => self::ID_IN_WORK_STATUS
        ],
        [
            'name' => self::NAME_OVERDUE_STATUS,
            'url' => 'tasks/mine', 'status' => self::ID_OVERDUE_STATUS
        ],
        [
            'name' => self::NAME_DONE_STATUS,
            'url' => 'tasks/mine', 'status' => self::ID_DONE_STATUS
        ]
    ];
}
