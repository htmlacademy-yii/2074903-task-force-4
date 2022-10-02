<?php
namespace app\controllers;

use omarinina\domain\models\task\TaskStatuses;
use omarinina\domain\models\Categories;
use omarinina\infrastructure\models\form\TaskFilterForm;
use yii\web\Controller;
use Yii;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $newTasks = TaskStatuses::findOne(['taskStatus' => 'new'])->newTasks;
        $categories = Categories::find()->all();

        $TaskFilterForm = new TaskFilterForm();
        if(Yii::$app->request->getIsPost()) {
            $TaskFilterForm->load(Yii::$app->request->post());
            if ($TaskFilterForm->validate()) {
                $newTasks = $TaskFilterForm->filter(TaskStatuses::findOne(['taskStatus' => 'new'])->getNewTasks())->all();
            }
        }

        return $this->render('tasks', [
            'newTasks' => $newTasks,
            'categories' => $categories,
            'model' => $TaskFilterForm
        ]);
    }
}
