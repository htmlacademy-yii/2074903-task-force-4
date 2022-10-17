<?php
namespace app\controllers;

use omarinina\domain\models\task\Responds;
use omarinina\domain\models\task\RespondStatuses;
use omarinina\domain\models\task\Tasks;
use yii\web\Response;

class TaskActionsController extends SecurityController
{
    public const ACCEPT_ACTION = 'accepted';
    public const REFUSE_ACTION = 'refused';

    /**
     * @param Responds $respond
     * @param Tasks $task
     * @param Responds[] $responds
     * @return \yii\web\Response
     */
    public function actionAcceptRespond(Responds $respond, Tasks $task, array $responds) : Response
    {
        if (\Yii::$app->user->id === $task->clientId && $task->taskStatus->taskStatus === Tasks::NEW_STATUS) {
            $task->executorId = $respond->executorId;
            $task->save(false);
            $respond->status = RespondStatuses::findOne(['status' => static::ACCEPT_ACTION])->id;
            $respond->save(false);

            foreach ($responds as $uniqueRespond) {
                if ($uniqueRespond->status === null) {
                    $uniqueRespond->status = RespondStatuses::findOne(['status' => static::REFUSE_ACTION])->id;
                    $uniqueRespond->save(false);
                }
            }
        }

        return $this->redirect(['tasks/view', 'id' => $task->id]);
    }

    public function actionRefuseRespond(Responds $respond, Tasks $task) : Response
    {
        if (\Yii::$app->user->id === $task->clientId && $task->taskStatus->taskStatus === Tasks::NEW_STATUS) {
            $respond->status = RespondStatuses::findOne(['status' => static::REFUSE_ACTION])->id;
            $respond->save(false);
        }

        return $this->redirect(['tasks/view', 'id' => $task->id]);
    }
}
