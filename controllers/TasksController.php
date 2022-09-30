<?php
namespace app\controllers;

use omarinina\domain\models\task\TaskStatuses;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $newTasks = TaskStatuses::findOne(['taskStatus' => 'new'])->newTasks;
        return $this->render('tasks', ['newTasks' => $newTasks]);
    }
}
