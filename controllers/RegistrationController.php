<?php

declare(strict_types=1);

namespace app\controllers;

use omarinina\application\services\file\parse\ServiceFileParse;
use omarinina\application\services\user\create\ServiceUserCreate;
use omarinina\infrastructure\models\form\RegistrationForm;
use omarinina\domain\models\Cities;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\web\ServerErrorHttpException;

class RegistrationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ],
            ],
        ];
    }

    /**
     * @param array|null $userData
     * @return string|Response
     */
    public function actionIndex(?array $userData = null): string|Response
    {
        try {
            $registrationForm = new RegistrationForm();
            $cities = Cities::find()->all();

            if (Yii::$app->request->getIsPost()) {
                $registrationForm->load(Yii::$app->request->post());

                if ($registrationForm->validate()) {
                    $avatarVk = array_key_exists('photo', $userData) ?
                        ServiceFileParse::parseAvatarVkFile($userData['photo']) :
                        null;
                    $newUser = ServiceUserCreate::createNewUser(
                        $registrationForm,
                        Yii::$app->request->post('RegistrationForm'),
                        $userData,
                        $avatarVk
                    );
                    if ($userData) {
                        return $this->redirect(['auth/login', 'userId' => $newUser->id]);
                    }
                    return $this->redirect(['site/index']);
                }
            }

            return $this->render('index', [
                'model' => $registrationForm,
                'cities' => $cities,
                'userData' => $userData
            ]);
        } catch (ServerErrorHttpException|\yii\base\Exception $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }
}
