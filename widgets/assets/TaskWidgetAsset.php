<?php
namespace app\widgets\assets;

use yii\web\AssetBundle;

class TaskWidgetAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css'
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
