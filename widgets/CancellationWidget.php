<?php

namespace app\widgets;

use yii\base\Widget;
use Yii;

class CancellationWidget extends Widget
{

    public function run()
    {
        if (Yii::$app->user->identity->userRole->role === 'client') {
            return $this->render('cancellationWidget');
        } else {
            return ;
        }
    }
}
