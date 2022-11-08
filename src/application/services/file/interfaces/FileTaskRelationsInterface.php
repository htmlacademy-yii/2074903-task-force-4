<?php

namespace omarinina\application\services\file\interfaces;

use omarinina\domain\models\task\TaskFiles;

interface FileTaskRelationsInterface
{
    /**
     * @param int $taskId
     * @param int $fileId
     * @return TaskFiles|null
     */
    public function saveRelationsFileTask(int $taskId, int $fileId) : ?TaskFiles;
}
