<?php

namespace omarinina\application\services\task\create;

use omarinina\domain\models\Files;
use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\models\form\CreateTaskForm;
use Yii;
use omarinina\domain\models\task\TaskStatuses;
use omarinina\domain\models\task\TaskFiles;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class ServiceTaskCreate
{
    /** @var CreateTaskForm */
    private CreateTaskForm $form;

    /** @var Tasks */
    private Tasks $newTask;

    /** @var Files */
    private Files $newFile;

    public function __construct(CreateTaskForm $form)
    {
        $this->form = $form;
    }

    /**
     * @return void
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function saveMainContent() : void
    {
        $this->newTask = new Tasks();
        $this->newTask->attributes = Yii::$app->request->post('CreateTaskForm');
        $this->newTask->clientId = Yii::$app->user->identity->id;
        $this->newTask->status = TaskStatuses::findOne(['taskStatus' => 'new'])->id;
        if ($this->form->expiryDate !== null) {
            $this->newTask->expiryDate = Yii::$app->formatter->asDate(
                $this->form->expiryDate,
                'yyyy-MM-dd HH:mm:ss'
            );
        }
        $this->newTask->save(false);

        if (!Tasks::findOne($this->newTask->id)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }

    /**
     * @param UploadedFile $file
     * @return void
     * @throws ServerErrorHttpException
     */
    public function saveFile(UploadedFile $file) : void
    {
        $this->newFile = new Files();
        $name = uniqid('upload') . '.' . $file->getExtension();
        $file->saveAs('@webroot/uploads/' . $name);
        $this->newFile->fileSrc = '/uploads/' . $name;
        $this->newFile->save(false);

        if (!Files::findOne($this->newFile->id)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }

    /**
     * @return void
     * @throws ServerErrorHttpException
     */
    public function saveRelationsTaskFile() : void
    {
        $taskFile = new TaskFiles();
        $taskFile->fileId = $this->newFile->id;
        $taskFile->taskId = $this->newTask->id;
        $taskFile->save(false);

        if (!TaskFiles::findOne($taskFile->id)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }

    /**
     * @return int
     */
    public function getIdNewTask() : int
    {
        return $this->newTask->id;
    }
}
