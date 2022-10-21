<?php

namespace omarinina\application\services\file\save;

use omarinina\domain\models\task\TaskFiles;
use yii\web\ServerErrorHttpException;

class  ServiceFileTaskRelations
{
    /**
     * @param int $taskId
     * @param int $fileId
     * @return TaskFiles|null
     * @throws ServerErrorHttpException
     */
    public static function saveRelationsFileTask(int $taskId, int $fileId) : ?TaskFiles
    {
        $taskFile = new TaskFiles();
        $taskFile->fileId = $fileId;
        $taskFile->taskId = $taskId;
        $taskFile->save(false);

        if (!$taskFile->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }

        return $taskFile;
    }

}
