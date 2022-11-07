<?php

declare(strict_types=1);

namespace omarinina\application\services\file;

use omarinina\application\services\file\interfaces\FileTaskRelationsInterface;
use omarinina\domain\models\task\TaskFiles;
use yii\web\ServerErrorHttpException;

class FileTaskRelationsService implements FileTaskRelationsInterface
{
    /**
     * @param int $taskId
     * @param int $fileId
     * @return TaskFiles|null
     * @throws ServerErrorHttpException
     */
    public function saveRelationsFileTask(int $taskId, int $fileId) : ?TaskFiles
    {
        $taskFile = new TaskFiles();
        $taskFile->fileId = $fileId;
        $taskFile->taskId = $taskId;

        if (!$taskFile->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }

        return $taskFile;
    }
}
