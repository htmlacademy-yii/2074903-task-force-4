<?php
namespace app\controllers;

use omarinina\application\services\respond\add_status\ServiceRespondStatusAdd;
use omarinina\application\services\respond\create\ServiceRespondCreate;
use omarinina\application\services\review\create\ServiceReviewCreate;
use omarinina\application\services\task\add_data\ServiceTaskDataAdd;
use omarinina\application\services\task\change_status\ServiceTaskStatusChange;
use omarinina\domain\exception\task\AvailableActionsException;
use omarinina\domain\exception\task\CurrentActionException;
use omarinina\domain\exception\task\IdUserException;
use omarinina\domain\models\task\Responds;
use omarinina\domain\models\task\Tasks;
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
     * @return Response|string
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionAcceptRespond(int $respondId) : Response|string
    {
        try {
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
        } catch (ServerErrorHttpException|NotFoundHttpException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $respondId
     * @return Response|string
     * @throws ServerErrorHttpException|NotFoundHttpException
     */
    public function actionRefuseRespond(int $respondId) : Response|string
    {
        try {
            if ($respondId) {
                $respond = Responds::findOne($respondId);
                $task = $respond->task;
                $userId = \Yii::$app->user->id;

                ServiceRespondStatusAdd::addRefuseStatus($respond, $userId);

                return $this->redirect(['tasks/view', 'id' => $task->id]);
            }
            throw new NotFoundHttpException('Respond is not found', 404);
        } catch (ServerErrorHttpException|NotFoundHttpException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $taskId
     * @return Response|string
     * @throws NotFoundHttpException
     * @throws AvailableActionsException
     * @throws CurrentActionException
     * @throws IdUserException
     * @throws ServerErrorHttpException
     */
    public function actionCancelTask(int $taskId) : Response|string
    {
        try {
            if ($taskId) {
                $task = Tasks::findOne($taskId);
                $userId = Yii::$app->user->id;

                if (ServiceTaskStatusChange::changeStatusToCancelled($task, $userId)) {
                    ServiceRespondStatusAdd::addRestRespondsRefuseStatus($task->responds);
                }

                return $this->redirect(['tasks/view', 'id' => $task->id]);
            }
            throw new NotFoundHttpException('Task is not found', 404);
        } catch (NotFoundHttpException|
            AvailableActionsException|
            CurrentActionException|
            IdUserException|
            ServerErrorHttpException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $taskId
     * @return Response|string
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionRespondTask(int $taskId) : Response|string
    {
        try {
            if ($taskId) {
                $task = Tasks::findOne($taskId);
                $user = Yii::$app->user->identity;
                $taskResponseForm = new TaskResponseForm();

                if (Yii::$app->request->getIsPost()) {
                    $taskResponseForm->load(Yii::$app->request->post());
                    if ($taskResponseForm->validate()) {
                        $attributes = Yii::$app->request->post('TaskResponseForm');

                        ServiceRespondCreate::saveNewRespond($user, $task, $attributes);

                        return $this->redirect(['tasks/view', 'id' => $taskId]);
                    }
                }
                throw new NotFoundHttpException('Page not found', 404);
            }
            throw new NotFoundHttpException('Task is not found', 404);
        } catch (NotFoundHttpException|ServerErrorHttpException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $taskId
     * @return Response|string
     */
    public function actionDenyTask(int $taskId) : Response|string
    {
        try {
            if ($taskId) {
                $task = Tasks::findOne($taskId);
                $userId = Yii::$app->user->id;

                ServiceTaskStatusChange::changeStatusToFailed($task, $userId);

                return $this->redirect(['tasks/view', 'id' => $taskId]);
            }
            throw new NotFoundHttpException('Task is not found', 404);
        } catch (NotFoundHttpException|ServerErrorHttpException $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @param int $taskId
     * @return Response|string
     */
    public function actionAcceptTask(int $taskId) : Response|string
    {
        try {
            if ($taskId) {
                $task = Tasks::findOne($taskId);
                $userId = Yii::$app->user->id;
                $taskAcceptanceForm = new TaskAcceptanceForm();

                if (ServiceTaskStatusChange::changeStatusToDone($task, $userId)) {
                    if (Yii::$app->request->getIsPost()) {
                        $taskAcceptanceForm->load(Yii::$app->request->post());
                        if ($taskAcceptanceForm->validate()) {
                            $attributes = Yii::$app->request->post('TaskAcceptanceForm');

                            ServiceReviewCreate::saveNewReview($task, $attributes);

                            return $this->redirect(['tasks/view', 'id' => $taskId]);
                        }
                    }
                }
                throw new NotFoundHttpException('Page not found', 404);
            }
            throw new NotFoundHttpException('Task is not found', 404);
        } catch (NotFoundHttpException|
            AvailableActionsException|
            CurrentActionException|
            IdUserException|
            ServerErrorHttpException $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }
}
