<?php
namespace app\controllers;

use omarinina\application\services\respond\add_status\ServiceRespondStatusAdd;
use omarinina\application\services\task\add_data\ServiceTaskDataAdd;
use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\models\task\Responds;
use omarinina\domain\models\task\RespondStatuses;
use omarinina\domain\models\task\Reviews;
use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\constants\RespondStatusConstants;
use omarinina\infrastructure\constants\TaskStatusConstants;
use omarinina\infrastructure\models\form\TaskResponseForm;
use omarinina\infrastructure\models\form\TaskAcceptanceForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;
use yii\web\ServerErrorHttpException;

class TaskActionsController extends SecurityController
{
    /**
     * @param int $respondId
     * @return Response
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionAcceptRespond(int $respondId) : Response
    {
        if ($respondId) {
            $respond = Responds::findOne($respondId);
            $userId = \Yii::$app->user->id;

            $task = ServiceTaskDataAdd::addExecutorIdToTask($respond, $userId);

            if (ServiceRespondStatusAdd::addAcceptStatus($respond, $userId)->status) {
                ServiceRespondStatusAdd::addRestRespondsRefuseStatus(
                    $task->responds,
                    $respond
                );
            }

            return $this->redirect(['tasks/view', 'id' => $task->id]);
        }
        throw new NotFoundHttpException('Respond is not found', 404);
    }

    /**
     * @param int $respondId
     * @return Response
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionRefuseRespond(int $respondId) : Response
    {
        if ($respondId) {
            $respond = Responds::findOne($respondId);
            $task = $respond->task;
            $userId = \Yii::$app->user->id;

            ServiceRespondStatusAdd::addRefuseStatus($respond, $userId);

            return $this->redirect(['tasks/view', 'id' => $task->id]);
        }
        throw new NotFoundHttpException('Respond is not found', 404);
    }

    public function actionCancelTask(int $taskId)
    {
        if ($taskId) {
            $task = Tasks::findOne($taskId);
            if (Yii::$app->user->id === $task->clientId) {
                $task->status = $task->changeStatusByAction(
                    CancelAction::getInternalName(),
                    \Yii::$app->user->id
                );
                $task->save(false);
                if ($task->responds) {
                    foreach ($task->responds as $respond) {
                        if (!$respond->status) {
                            $respond->status = RespondStatuses::findOne(['status' => static::REFUSE_ACTION])->id;
                            $respond->save(false);
                        }
                    }
                }
                return $this->redirect(['tasks/view', 'id' => $task->id]);
            }
        }
        throw new NotFoundHttpException('Task is not found', 404);
    }

    public function actionRespondTask(int $taskId)
    {
        if ($taskId) {
            $task = Tasks::findOne($taskId);
            $user = Yii::$app->user->identity;
            $taskResponseForm = new TaskResponseForm();
            if ($user->userRole->role === 'executor' &&
                !$user->getResponds()->where(['taskId' => $taskId])->one() &&
                $task->taskStatus->taskStatus = Tasks::NEW_STATUS
            ) {
                if (Yii::$app->request->getIsPost()) {
                    $taskResponseForm->load(Yii::$app->request->post());
                    if ($taskResponseForm->validate()) {
                        $newRespond = new Responds();
                        $newRespond->attributes = Yii::$app->request->post('TaskResponseForm');
                        $newRespond->taskId = $taskId;
                        $newRespond->executorId = $user->id;
                        $newRespond->save(false);
                        return $this->redirect(['tasks/view', 'id' => $taskId]);
                    }
                }
            }
                throw new NotFoundHttpException('Page not found', 404);
        }
            throw new NotFoundHttpException('Task is not found', 404);
    }


    public function actionDenyTask(int $taskId)
    {
        if ($taskId) {
            $task = Tasks::findOne($taskId);
            if (Yii::$app->user->id === $task->executorId) {
                $task->status = $task->changeStatusByAction(
                    DenyAction::getInternalName(),
                    \Yii::$app->user->id
                );
                $task->save(false);
                return $this->redirect(['tasks/view', 'id' => $taskId]);
            }
        }
        throw new NotFoundHttpException('Task is not found', 404);
    }

    public function actionAcceptTask(int $taskId)
    {
        if ($taskId) {
            $task = Tasks::findOne($taskId);
            $taskAcceptanceForm = new TaskAcceptanceForm();
            if (Yii::$app->user->id === $task->clientId) {
                $task->status = $task->changeStatusByAction(
                    AcceptAction::getInternalName(),
                    \Yii::$app->user->id
                );
                $task->save(false);
                if (Yii::$app->request->getIsPost()) {
                    $taskAcceptanceForm->load(Yii::$app->request->post());
                    if ($taskAcceptanceForm->validate()) {
                        $newReview = new Reviews();
                        $newReview->attributes = Yii::$app->request->post('TaskAcceptanceForm');
                        $newReview->taskId = $taskId;
                        $newReview->executorId = $task->executorId;
                        $newReview->clientId = $task->clientId;
                        $newReview->save(false);
                        return $this->redirect(['tasks/view', 'id' => $taskId]);
                    }
                }
            }
            throw new NotFoundHttpException('Page not found', 404);
        }
        throw new NotFoundHttpException('Task is not found', 404);
    }
}
