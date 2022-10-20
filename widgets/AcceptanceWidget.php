<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use omarinina\infrastructure\models\form\TaskAcceptanceForm;

class AcceptanceWidget extends Widget
{

    public function run()
    {
        if (Yii::$app->user->identity->userRole->role === 'client') {
            $model = new TaskAcceptanceForm();
            return $this->render('acceptanceWidget', [
                'model' => $model,
            ]);
        } else {
            return ;
        }
    }
}
