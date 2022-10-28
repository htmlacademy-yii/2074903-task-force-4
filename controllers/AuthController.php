<?php

namespace app\controllers;

use omarinina\application\services\user\auth\ServiceUserAuthVk;
use yii\authclient\OAuthToken;
use yii\web\Controller;
use Yii;

class AuthController extends Controller
{
    /**
     * @return void
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAuthorizeUserViaVk()
    {
        $codeVk = Yii::$app->request->get('code');
        $vkClient = ServiceUserAuthVk::getVkClientOAuth();

        /** @var OAuthToken $token */
        $token = $vkClient->fetchAccessToken($codeVk);

        $requestOAuth = $vkClient->createRequest();
        $vkClient->applyAccessTokenToRequest($requestOAuth, $token);

        $userData = $vkClient->getUserAttributes();


    }
}
