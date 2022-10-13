<?php
namespace app\controllers;

use yii\web\BadRequestHttpException;
use omarinina\domain\models\task\TaskStatuses;
use omarinina\domain\models\Categories;
use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\models\form\TaskFilterForm;
use omarinina\infrastructure\models\form\CreateTaskForm;
use Yii;
use yii\web\NotFoundHttpException;

class TasksController extends SecurityController
{
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
        if (Yii::$app->user->identity->userRole->role === 'executor') {
            throw new NotFoundHttpException('You do not have access to create tasks', 403);
        }
        $categories = Categories::find()->all();
        $model = new CreateTaskForm();


        //need to save notnull params - clientId and status
        return $this->render('create', [
            'model' => $model,
            'categories' => $categories
        ]);
    }
}
