<?php

declare(strict_types=1);

namespace app\controllers;

use omarinina\application\services\user\interfaces\UserAuthVkInterface;
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
    /** @var UserAuthVkInterface */
    private UserAuthVkInterface $userAuthVk;

    public function __construct(
        $id,
        $module,
        UserAuthVkInterface $userAuthVk,
        $config = []
    ) {
        $this->userAuthVk = $userAuthVk;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return Response|string
     */
    public function actionAuthorizeUserViaVk() : Response|string
    {
        try {
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            /** @var Collection $collectionClientsOAuth */
            $collectionClientsOAuth = Yii::$app->get('authClientCollection');
            /** @var VKontakte $vkClientOAuth */
            $vkClientOAuth = $collectionClientsOAuth->getClient('vkontakte');

            $codeVk = Yii::$app->request->get('code');
            $userData = $this->userAuthVk->applyAccessTokenForVk($codeVk, $vkClientOAuth)->getUserAttributes();

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
        } catch (HttpException|InvalidConfigException|ServerErrorHttpException $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            Yii::$app->errorHandler->logException($e);
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @param int $userId
     * @return Response|string
     */
    public function actionLogin(int $userId) : Response|string
    {
        try {
            $newUser = Users::findOne($userId);
            Yii::$app->user->login($newUser);
            return $this->redirect(['site/index']);
        } catch (\Throwable $e) {
            Yii::$app->errorHandler->logException($e);
            return 'Something wrong. Sorry, please, try again later';
        }
    }
}
