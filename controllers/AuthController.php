<?php

namespace app\controllers;

use omarinina\application\services\user\auth\ServiceUserAuthVk;
use omarinina\domain\models\user\Users;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\web\Response;

class AuthController extends Controller
{
    /**
     * @return Response
     * @throws InvalidConfigException
     * @throws HttpException
     */
    public function actionAuthorizeUserViaVk() : Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $codeVk = Yii::$app->request->get('code');
        $userData = ServiceUserAuthVk::applyAccessTokenForVk($codeVk)->getUserAttributes();
        if ($userData) {
            $currentUser = Users::findOne(['vkId' => $userData['id']]);
            if (!$currentUser) {
                $currentUser = ;
                //create new user
            }
            Yii::$app->user->login($currentUser);
        }
    }
}
