<?php

namespace app\controllers;

use omarinina\application\services\user\add_data\ServiceUserDataAdd;
use omarinina\application\services\user\auth\ServiceUserAuthVk;
use omarinina\domain\models\Cities;
use omarinina\domain\models\user\Users;
use omarinina\infrastructure\models\form\RegistrationCityRoleForm;
use omarinina\infrastructure\models\form\RegistrationRoleForm;
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

        $codeVk = Yii::$app->request->get('code');
        $userData = ServiceUserAuthVk::applyAccessTokenForVk($codeVk)->getUserAttributes();

        if ($userData) {
            $currentUser = Users::findOne(['vkId' => $userData['id']]);
            if (!$currentUser) {
                if (array_key_exists('email', $userData)) {
                    $currentUser = Users::findOne(['email' => mb_strtolower($userData['email'])]);
                    if ($currentUser) {
                        ServiceUserDataAdd::addUserVkId($currentUser, $userData);
                    }
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
     * @param Users $user
     * @return Response
     */
    public function actionLogin(Users $user) : Response
    {
        Yii::$app->user->login($user);
        return $this->redirect(['site/index']);
    }
}
