<?php

namespace app\widgets;

use yii\base\Widget;
use Yii;

class DenialWidget extends Widget
{

    public function run()
    {
        if (Yii::$app->user->identity->userRole->role === 'executor') {
            return $this->render('denialWidget');
        } else {
            return ;
        }
    }

}
