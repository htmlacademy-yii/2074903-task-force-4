<?php
namespace app\controllers;

use omarinina\application\services\task\create\ServiceTaskCreate;
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
                return $user->userRole->role !== 'client';
            }
        ];
        array_unshift($rules['access']['rules'], $rule);
        return $rules;
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionIndex(): string
    {
        try {
            $categories = Categories::find()->all();
            $TaskFilterForm = new TaskFilterForm();

            $TaskFilterForm->load(Yii::$app->request->post());
            if ($TaskFilterForm->validate()) {
                $newTasks = $TaskFilterForm->filter(TaskStatuses::findOne(['taskStatus' => 'new'])
                    ->getNewTasks())->all();
            } else {
                throw new BadRequestHttpException('Bad request', 400);
            }

            return $this->render('index', [
                'newTasks' => $newTasks,
                'categories' => $categories,
                'model' => $TaskFilterForm,
            ]);
        } catch (BadRequestHttpException|\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        try {
            if ($id) {
                $currentTask = Tasks::findOne($id);
                $responds = Yii::$app->user->id === $currentTask->clientId ?
                    $currentTask->responds :
                    Yii::$app->user->identity->getResponds()->where(['taskId' => $currentTask->id])->one();
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
        }
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionCreate() : string|Response
    {
        try {
            $categories = Categories::find()->all();
            $createTaskForm = new CreateTaskForm();
            $newTask = new ServiceTaskCreate($createTaskForm);

            if (Yii::$app->request->getIsPost()) {
                $createTaskForm->load(Yii::$app->request->post());

                if ($createTaskForm->validate()) {
                    $newTask->saveMainContent();
                    foreach (UploadedFile::getInstances($createTaskForm, 'files') as $file) {
                        $newTask->saveFile($file);
                        $newTask->saveRelationsTaskFile();
                    }
                    return $this->redirect(['view', 'id' => $newTask->getIdNewTask()]);
                }
            }
            return $this->render('create', [
                'model' => $createTaskForm,
                'categories' => $categories
            ]);
        } catch (ServerErrorHttpException|InvalidConfigException $e) {
            return $e->getMessage();
        }
    }
}
