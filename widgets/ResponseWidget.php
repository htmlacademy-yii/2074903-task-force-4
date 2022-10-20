<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use omarinina\infrastructure\models\form\TaskResponseForm;

class ResponseWidget extends Widget
{

    public function run()
    {
        if (Yii::$app->user->identity->userRole->role === 'executor') {
            $model = new TaskResponseForm();
            return $this->render('responseWidget', [
                'model' => $model,
            ]);
        } else {
            return ;
        }
    }
}
