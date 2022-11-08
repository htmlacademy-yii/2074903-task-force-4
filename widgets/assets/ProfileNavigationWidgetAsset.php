<?php
namespace app\widgets\assets;

use yii\web\AssetBundle;

class ProfileNavigationWidgetAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/main.js'
    ];
    public $depends = [
    ];
}
