<?php

namespace omarinina\infrastructure\constants;

class TaskStatusConstants
{
    public const ID_NEW_STATUS = 1;
    public const ID_CANCELLED_STATUS = 2;
    public const ID_IN_WORK_STATUS = 3;
    public const ID_DONE_STATUS = 4;
    public const ID_FAILED_STATUS = 5;

    public const NEW_STATUS = 'new';
    public const CANCELLED_STATUS = 'cancelled';
    public const IN_WORK_STATUS = 'in work';
    public const DONE_STATUS = 'done';
    public const FAILED_STATUS = 'failed';
}
