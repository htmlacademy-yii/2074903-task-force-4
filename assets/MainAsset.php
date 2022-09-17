<?php
namespace app\assets;

use yii\web\AssetBundle;

//Asset for pages with main.js
class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/main.js'
    ];
    //do we need to save 'depends' for our own asset?
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}