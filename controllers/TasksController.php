<?php

declare(strict_types=1);

namespace app\controllers;

use GuzzleHttp\Exception\GuzzleException;
use omarinina\application\services\file\interfaces\FileSaveInterface;
use omarinina\application\services\file\interfaces\FileTaskRelationsInterface;
use omarinina\application\services\location\interfaces\GeoObjectReceiveInterface;
use omarinina\application\services\task\dto\NewTaskDto;
use omarinina\application\services\task\interfaces\TaskCreateInterface;
use omarinina\application\services\task\interfaces\TaskFilterInterface;
use omarinina\infrastructure\constants\UserRoleConstants;
use omarinina\infrastructure\constants\TaskStatusConstants;
use Throwable;
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
    /** @var FileSaveInterface */
    private FileSaveInterface $fileSave;

    /** @var FileTaskRelationsInterface  */
    private FileTaskRelationsInterface $fileTaskRelations;

    /** @var TaskCreateInterface  */
    private TaskCreateInterface $taskCreate;

    /** @var TaskFilterInterface */
    private TaskFilterInterface $taskFilter;

    /** @var GeoObjectReceiveInterface */
    private GeoObjectReceiveInterface $geoObjectReceive;

    public function __construct(
        $id,
        $module,
        FileSaveInterface $fileSave,
        FileTaskRelationsInterface $fileTaskRelations,
        TaskCreateInterface $taskCreate,
        TaskFilterInterface $taskFilter,
        GeoObjectReceiveInterface $geoObjectReceive,
        $config = []
    ) {
        $this->fileSave = $fileSave;
        $this->fileTaskRelations = $fileTaskRelations;
        $this->taskCreate = $taskCreate;
        $this->taskFilter = $taskFilter;
        $this->geoObjectReceive = $geoObjectReceive;
        parent::__construct($id, $module, $config);
    }

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
     * @param int|null $category
     * @return string
     */
    public function actionIndex(?int $category = null): string
    {
        try {
            $categories = Categories::find()->all();
            $taskFilterForm = new TaskFilterForm();

            if ($category) {
                $taskFilterForm->categories[] = $category;
            }

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
        } catch (Throwable $e) {
            Yii::$app->errorHandler->logException($e);
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
        } catch (Throwable $e) {
            Yii::$app->errorHandler->logException($e);
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
                    if (!$createTaskForm->isLocationExistGeocoder() && $createTaskForm->location) {
                        Yii::$app->session->setFlash(
                            'error',
                            '???????????????????? ???????????? ???????????? ???? ???????? ??????????????. ????????????????????, ???????????????????? ??????-???????????? ????????????????.'
                        );
                        return $this->render('create', [
                            'model' => $createTaskForm,
                            'categories' => $categories
                        ]);
                    }
                    $createdTask = $this->taskCreate->createNewTask(new NewTaskDto(
                        Yii::$app->request->post('CreateTaskForm'),
                        Yii::$app->user->id,
                        $createTaskForm->expiryDate,
                        $this->geoObjectReceive->receiveGeoObjectFromYandexGeocoder($createTaskForm->location)
                    ));
                    foreach (UploadedFile::getInstances($createTaskForm, 'files') as $file) {
                        $savedFile = $this->fileSave->saveNewFile($file);
                        $this->fileTaskRelations->saveRelationsFileTask($createdTask->id, $savedFile->id);
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
        } catch (Throwable $e) {
            Yii::$app->errorHandler->logException($e);
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @param int|null $status
     * @return string
     * @throws Throwable
     */
    public function actionMine(?int $status = null) : string
    {
        try {
            $currentUser = Yii::$app->user->identity;
            $allTasks = $currentUser->role === UserRoleConstants::ID_CLIENT_ROLE ?
                $this->taskFilter->filterClientTasksByStatus($currentUser->id, $status) :
                $this->taskFilter->filterExecutorTasksByStatus($currentUser->id, $status);
            $title = $currentUser->role === UserRoleConstants::ID_CLIENT_ROLE ?
                ViewConstants::CLIENT_TASK_FILTER_TITLES[$status] :
                ViewConstants::EXECUTOR_TASK_FILTER_TITLES[$status];

            return $this->render('mine', [
                'title' => $title,
                'tasks' => $allTasks,
            ]);
        } catch (Throwable $e) {
            Yii::$app->errorHandler->logException($e);
            return 'Something wrong. Sorry, please, try again later';
        }
    }
}
