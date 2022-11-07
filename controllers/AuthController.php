<?php

declare(strict_types=1);

namespace app\controllers;

use omarinina\application\services\user\auth\ServiceUserAuthVk;
use omarinina\domain\models\user\Users;
use yii\authclient\clients\VKontakte;
use yii\authclient\Collection;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class AuthController extends Controller
{
    /**
     * @return Response|string
     * @throws HttpException
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionAuthorizeUserViaVk() : Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        /** @var Collection $collectionClientsOAuth */
        $collectionClientsOAuth = Yii::$app->get('authClientCollection');
        /** @var VKontakte $vkClientOAuth */
        $vkClientOAuth = $collectionClientsOAuth->getClient('vkontakte');

        $codeVk = Yii::$app->request->get('code');
        $userData = ServiceUserAuthVk::applyAccessTokenForVk($codeVk, $vkClientOAuth)->getUserAttributes();

        if ($userData) {
            $currentUser = Users::findOne(['vkId' => $userData['id']]);
            if (!$currentUser) {
                if (array_key_exists('email', $userData)) {
                    $currentUser = Users::findOne(['email' => mb_strtolower($userData['email'])]);
                    $currentUser?->addVkId($userData['id']);
                }
                if (!$currentUser) {
                    return $this->redirect([
                        'registration/index',
                        'userData' => $userData
                    ]);
                }
            }
            if ($currentUser) {
                Yii::$app->user->login($currentUser);
                return $this->redirect(['site/index']);
            }
        }
        throw new NotFoundHttpException();
    }

    /**
     * @param int $userId
     * @return Response
     */
    public function actionLogin(int $userId) : Response
    {
        $newUser = Users::findOne($userId);
        Yii::$app->user->login($newUser);
        return $this->redirect(['site/index']);
    }
}
