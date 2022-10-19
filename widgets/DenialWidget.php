<?php

namespace app\widgets;

use yii\base\Widget;

class DenialWidget extends Widget
{

    public function run()
    {
        return $this->render('denialWidget');
    }

}
