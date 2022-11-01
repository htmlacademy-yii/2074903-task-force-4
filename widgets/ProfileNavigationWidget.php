<?php

namespace app\widgets;

use yii\base\Widget;

class ProfileNavigationWidget extends Widget
{
    public function run()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('profileNavigationWidget');
        }
        return;
    }
}
