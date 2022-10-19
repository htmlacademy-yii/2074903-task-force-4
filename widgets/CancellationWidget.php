<?php

namespace app\widgets;

use yii\base\Widget;

class CancellationWidget extends Widget
{

    public function run()
    {
        return $this->render('cancellationWidget');
    }

}
