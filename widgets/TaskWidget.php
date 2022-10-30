<?php

namespace app\widgets;

use omarinina\domain\models\task\Tasks;
use yii\base\Widget;

class TaskWidget extends Widget
{
    public Tasks $task;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('taskWidget', ['task' => $this->task]);
        }
        return;
    }
}
