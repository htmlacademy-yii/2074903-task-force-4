<?php
namespace app\assets;

use yii\web\AssetBundle;

class BasicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css'
    ];
    public $js = [
    ];
    //do we need to save 'depends' for our own asset?
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}