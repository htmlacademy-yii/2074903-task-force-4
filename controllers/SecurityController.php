<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class SecurityController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->user->loginUrl = Yii::$app->homeUrl;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }
}
