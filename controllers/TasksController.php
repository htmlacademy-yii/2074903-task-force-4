<?php
namespace app\controllers;

use omarinina\domain\models\Files;
use omarinina\domain\models\task\TaskFiles;
use yii\web\BadRequestHttpException;
use omarinina\domain\models\task\TaskStatuses;
use omarinina\domain\models\Categories;
use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\models\form\TaskFilterForm;
use omarinina\infrastructure\models\form\CreateTaskForm;
use Yii;
use yii\web\NotFoundHttpException;
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
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        if ($id) {
            $currentTask = Tasks::findOne($id);
            if (!$currentTask) {
                throw new NotFoundHttpException('Task is not found', 404);
            }
        } else {
            throw new NotFoundHttpException('Task is not found', 404);
        }

        return $this->render('view', [
            'currentTask' => $currentTask,
        ]);
    }

    public function actionCreate()
    {
        $categories = Categories::find()->all();
        $createTaskForm = new CreateTaskForm();
        $newTask = new Tasks();

        if (Yii::$app->request->getIsPost()) {
            $createTaskForm->load(Yii::$app->request->post());

            if ($createTaskForm->validate()) {
                $newTask->attributes = Yii::$app->request->post('CreateTaskForm');
                $newTask->clientId = Yii::$app->user->identity->id;
                $newTask->status = TaskStatuses::findOne(['taskStatus' => 'new'])->id;
                if ($createTaskForm->expiryDate !== null) {
                    $newTask->expiryDate = Yii::$app->formatter->asDate(
                        $createTaskForm->expiryDate,
                        'yyyy-MM-dd HH:mm:ss'
                    );
                }
                $newTask->save(false);
                foreach (UploadedFile::getInstances($createTaskForm, 'files') as $file) {
                    $newFile = new Files();
                    $taskFile = new TaskFiles();
                    $name = uniqid('upload') . '.' . $file->getExtension();
                    $file->saveAs('@webroot/uploads/' . $name);
                    $newFile->fileSrc = '/uploads/' . $name;
                    $newFile->save(false);
                    $taskFile->fileId = $newFile->id;
                    $taskFile->taskId = $newTask->id;
                    $taskFile->save(false);
                }
                return $this->redirect(['view', 'id' => $newTask->id]);
            }
        }
        return $this->render('create', [
            'model' => $createTaskForm,
            'categories' => $categories
        ]);
    }
}
