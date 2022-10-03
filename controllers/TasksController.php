<?php
namespace app\controllers;

use http\Exception\RuntimeException;
use omarinina\domain\models\task\TaskStatuses;
use omarinina\domain\models\Categories;
use omarinina\infrastructure\models\form\TaskFilterForm;
use yii\web\Controller;
use Yii;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $categories = Categories::find()->all();
        $TaskFilterForm = new TaskFilterForm();

        $TaskFilterForm->load(Yii::$app->request->post());
        if ($TaskFilterForm->validate()) {
            $newTasks = $TaskFilterForm->filter(TaskStatuses::findOne(['taskStatus' => 'new'])
                ->getNewTasks())->all();
        } else {
            throw new RuntimeException('Bad request', 400);
        }


        return $this->render('tasks', [
            'newTasks' => $newTasks,
            'categories' => $categories,
            'model' => $TaskFilterForm
        ]);
    }
}
