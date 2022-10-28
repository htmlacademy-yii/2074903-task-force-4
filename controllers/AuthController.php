<?php

namespace app\controllers;

use omarinina\application\services\user\add_data\ServiceUserDataAdd;
use omarinina\application\services\user\auth\ServiceUserAuthVk;
use omarinina\domain\models\Cities;
use omarinina\domain\models\user\Users;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
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
                $currentUser = Users::findOne(['email' => $userData['email']]);
                if ($currentUser) {
                    $currentUser = ServiceUserDataAdd::addUserVkId($currentUser, $userData);
                } else {
                    if (!$userData['city'] || !Cities::findOne(['name' => $userData['city']])->id) {
                        return $this->render('registration/city', [
                            'model' => $registrationCityRoleForm,
                        ]);
                    }
                    return $this->render('registration/role', [
                        'model' => $registrationRoleForm
                    ]);
                //create new user
                    }
            }
            Yii::$app->user->login($currentUser);
        }
    }
}
