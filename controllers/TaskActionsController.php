<?php

declare(strict_types=1);

namespace app\controllers;

use omarinina\application\services\respond\interfaces\RespondCreateInterface;
use omarinina\application\services\respond\interfaces\RespondStatusAddInterface;
use omarinina\application\services\respond\dto\NewRespondDto;
use omarinina\application\services\review\create\ServiceReviewCreate;
use omarinina\application\services\task\addData\ServiceTaskDataAdd;
use omarinina\application\services\task\changeStatus\ServiceTaskStatusChange;
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
    /** @var RespondStatusAddInterface */
    private RespondStatusAddInterface $respondStatusAdd;

    /** @var RespondCreateInterface */
    private RespondCreateInterface $respondCreate;

    public function __construct(
        $id,
        $module,
        RespondStatusAddInterface $respondStatusAdd,
        RespondCreateInterface $respondCreate,
        $config = []
    ) {
        $this->respondStatusAdd = $respondStatusAdd;
        $this->respondCreate = $respondCreate;
        parent::__construct($id, $module, $config);
    }


    /**
     * @param int $respondId
     * @return Response|string
     */
    public function actionAcceptRespond(int $respondId) : Response|string
    {
        try {
            if ($respondId) {
                $respond = Responds::findOne($respondId);
                $userId = \Yii::$app->user->id;

                $task = ServiceTaskDataAdd::addExecutorIdToTask($respond, $userId);

                if ($this->respondStatusAdd->addAcceptStatus($respond, $userId)->status) {
                    ServiceTaskStatusChange::changeStatusToInWork($task);
                    $this->respondStatusAdd->addRestRespondsRefuseStatus(
                        $task->responds,
                        $respond
                    );
                }

                return $this->redirect(['tasks/view', 'id' => $task->id]);
            }
            throw new NotFoundHttpException('Respond is not found', 404);
        } catch (ServerErrorHttpException|NotFoundHttpException $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @param int $respondId
     * @return Response|string
     */
    public function actionRefuseRespond(int $respondId) : Response|string
    {
        try {
            if ($respondId) {
                $respond = Responds::findOne($respondId);
                $task = $respond->task;
                $userId = \Yii::$app->user->id;

                $this->respondStatusAdd->addRefuseStatus($respond, $userId);

                return $this->redirect(['tasks/view', 'id' => $task->id]);
            }
            throw new NotFoundHttpException('Respond is not found', 404);
        } catch (ServerErrorHttpException|NotFoundHttpException $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @param int $taskId
     * @return Response|string
     */
    public function actionCancelTask(int $taskId) : Response|string
    {
        try {
            if ($taskId) {
                $task = Tasks::findOne($taskId);
                $userId = Yii::$app->user->id;

                if (ServiceTaskStatusChange::changeStatusToCancelled($task, $userId)) {
                    $this->respondStatusAdd->addRestRespondsRefuseStatus($task->responds);
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
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @param int $taskId
     * @return Response|string
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
                    if ($taskResponseForm->validate() && $taskResponseForm->isAvailableAddRespond($user, $task)) {
                        $attributes = Yii::$app->request->post('TaskResponseForm');

                        $this->respondCreate->saveNewRespond(new NewRespondDto($user->id, $task->id, $attributes));

                        return $this->redirect(['tasks/view', 'id' => $taskId]);
                    }
                }
                throw new NotFoundHttpException('Page not found', 404);
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
