<?php
namespace app\controllers;

use omarinina\domain\models\task\Responds;
use omarinina\domain\models\task\RespondStatuses;
use omarinina\domain\models\task\Tasks;

class TaskActionsController extends SecurityController
{
    public function actionAcceptRespond(Responds $respond, Tasks $task)
    {
        $acceptAction = 'accepted';
        if (\Yii::$app->user->id === $task->clientId && $task->taskStatus->taskStatus === Tasks::NEW_STATUS) {
            $task->executorId = $respond->executorId;
            $task->save(false);
            $respond->status = RespondStatuses::findOne(['status' => $acceptAction])->id;
            $respond->save(false);
        }
    }
}
