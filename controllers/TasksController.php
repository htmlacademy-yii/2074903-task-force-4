<?php
namespace app\controllers;

use GuzzleHttp\Exception\GuzzleException;
use omarinina\application\services\file\save\ServiceFileSave;
use omarinina\application\services\file\save\ServiceFileTaskRelations;
use omarinina\application\services\location\pointReceive\ServiceGeoObjectReceive;
use omarinina\application\services\task\create\ServiceTaskCreate;
use omarinina\application\services\task\filter\ServiceTaskFilter;
use omarinina\infrastructure\constants\UserRoleConstants;
use omarinina\infrastructure\constants\TaskStatusConstants;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use omarinina\domain\models\task\TaskStatuses;
use omarinina\domain\models\Categories;
use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\models\form\TaskFilterForm;
use omarinina\infrastructure\models\form\CreateTaskForm;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use yii\data\Pagination;
use omarinina\infrastructure\constants\ViewConstants;

class TasksController extends SecurityController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'matchCallback' => function ($rule, $action) {
                $user = Yii::$app->user->identity;
                return $user->userRole->role !== UserRoleConstants::CLIENT_ROLE;
            }
        ];
        array_unshift($rules['access']['rules'], $rule);
        return $rules;
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        try {
            $categories = Categories::find()->all();
            $taskFilterForm = new TaskFilterForm();

            $taskFilterForm->load(Yii::$app->request->post());
            if ($taskFilterForm->validate()) {
                $newTasks = $taskFilterForm
                    ->filter(TaskStatuses::findOne(['taskStatus' => TaskStatusConstants::NEW_STATUS])
                    ->getNewTasks());
                $pagination = new Pagination([
                    'totalCount' => $newTasks->count(),
                    'pageSize' => ViewConstants::PAGE_COUNTER,
                    'forcePageParam' => false,
                    'pageSizeParam' => false
                ]);
                $newTasksWithPagination = $newTasks->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
            } else {
                throw new BadRequestHttpException('Bad request', 400);
            }

            return $this->render('index', [
                'newTasks' => $newTasksWithPagination,
                'categories' => $categories,
                'model' => $taskFilterForm,
                'pagination' => $pagination
            ]);
        } catch (BadRequestHttpException|\Exception $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionView(int $id): string
    {
        try {
            if ($id) {
                $currentTask = Tasks::findOne($id);
                $responds = Yii::$app->user->id === $currentTask->clientId ?
                    $currentTask->responds :
                    Yii::$app->user->identity->getResponds()->where(['taskId' => $currentTask->id])->all();
                if (!$currentTask) {
                    throw new NotFoundHttpException('Task is not found', 404);
                }
            } else {
                throw new NotFoundHttpException('Task is not found', 404);
            }

            return $this->render('view', [
                'currentTask' => $currentTask,
                'responds' => $responds
            ]);
        } catch (NotFoundHttpException|\yii\base\InvalidConfigException|\Exception $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @return string|Response
     */
    public function actionCreate() : string|Response
    {
        try {
            $categories = Categories::find()->all();
            $createTaskForm = new CreateTaskForm();

            if (Yii::$app->request->getIsPost()) {
                $createTaskForm->load(Yii::$app->request->post());

                if ($createTaskForm->validate()) {
                    if (!$createTaskForm->isLocationExistGeocoder()) {
                        Yii::$app->session->setFlash(
                            'error',
                            'Координаты вашего адреса не были найдены. Пожалуйста, попробуйте что-нибудь изменить.'
                        );
                        return $this->render('create', [
                            'model' => $createTaskForm,
                            'categories' => $categories
                        ]);
                    }
                    $createdTask = ServiceTaskCreate::saveNewTask(
                        Yii::$app->request->post('CreateTaskForm'),
                        Yii::$app->user->id,
                        $createTaskForm->expiryDate,
                        ServiceGeoObjectReceive::receiveGeoObjectFromYandexGeocoder($createTaskForm->location)
                    );
                    foreach (UploadedFile::getInstances($createTaskForm, 'files') as $file) {
                        $savedFile = ServiceFileSave::saveNewFile($file);
                        ServiceFileTaskRelations::saveRelationsFileTask($createdTask->id, $savedFile->id);
                    }
                    return $this->redirect(['view', 'id' => $createdTask->id]);
                }
            }
            return $this->render('create', [
                'model' => $createTaskForm,
                'categories' => $categories
            ]);
        } catch (ServerErrorHttpException|InvalidConfigException|NotFoundHttpException $e) {
            return $e->getMessage();
        } catch (GuzzleException $e) {
            return 'Your data has not been recorded with location, please, try again later';
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    public function actionMine(?int $status = null)
    {
        $currentUser = Yii::$app->user->identity;
        $allTasks = $currentUser->role === UserRoleConstants::ID_CLIENT_ROLE ?
            ServiceTaskFilter::filterClientTasks($currentUser->id, $status) :
            ServiceTaskFilter::filterExecutorTasks($currentUser->id, $status);
        $title = $currentUser->role === UserRoleConstants::ID_CLIENT_ROLE ?
            ViewConstants::CLIENT_TASK_FILTER_TITLES[$status] :
            ViewConstants::EXECUTOR_TASK_FILTER_TITLES[$status];

        return $this->render('mine', [
            'title' => $title,
            'tasks' => $allTasks,
            ]);
    }
}
