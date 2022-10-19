<?php
namespace app\controllers;

use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;
use omarinina\domain\models\task\Responds;
use omarinina\domain\models\task\RespondStatuses;
use omarinina\domain\models\task\Tasks;
use yii\web\Response;

class TaskActionsController extends SecurityController
{
    public const ACCEPT_ACTION = 'accepted';
    public const REFUSE_ACTION = 'refused';

    /**
     * @param int $respondId
     * @return Response
     */
    public function actionAcceptRespond(int $respondId) : Response
    {
        $respond = Responds::findOne($respondId);
        $task = $respond->task;
        $responds = $task->responds;

        if (\Yii::$app->user->id === $task->clientId && $task->taskStatus->taskStatus === Tasks::NEW_STATUS) {
            $task->executorId = $respond->executorId;
            $task->save(false);
            $respond->status = RespondStatuses::findOne(['status' => static::ACCEPT_ACTION])->id;
            $respond->save(false);

            foreach ($responds as $uniqueRespond) {
                if (!$uniqueRespond->status && $uniqueRespond->id !== $respond->id) {
                    $uniqueRespond->status = RespondStatuses::findOne(['status' => static::REFUSE_ACTION])->id;
                    $uniqueRespond->save(false);
                }
            }
        }

        return $this->redirect(['tasks/view', 'id' => $task->id]);
    }

    /**
     * @param int $respondId
     * @return Response
     */
    public function actionRefuseRespond(int $respondId) : Response
    {
        $respond = Responds::findOne($respondId);
        $task = $respond->task;

        if (\Yii::$app->user->id === $task->clientId && $task->taskStatus->taskStatus === Tasks::NEW_STATUS) {
            $respond->status = RespondStatuses::findOne(['status' => static::REFUSE_ACTION])->id;
            $respond->save(false);
        }

        return $this->redirect(['tasks/view', 'id' => $task->id]);
    }

    public function actionCancelTask(int $taskId)
    {
        Tasks::findOne($taskId)->changeStatusByAction(
            CancelAction::getInternalName(),
            \Yii::$app->user->id
        );
    }

    public function actionRespondTask(string $currentStatus, int $taskId)
    {
        Tasks::findOne($taskId)->changeStatusByAction(
            RespondAction::getInternalName(),
            \Yii::$app->user->id
        );
    }

    public function actionDenyTask(string $currentStatus, int $taskId)
    {
        Tasks::findOne($taskId)->changeStatusByAction(
            DenyAction::getInternalName(),
            \Yii::$app->user->id
        );
    }

    public function actionAcceptTask(string $currentStatus, int $taskId)
    {
        Tasks::findOne($taskId)->changeStatusByAction(
            AcceptAction::getInternalName(),
            \Yii::$app->user->id
        );
    }
}
