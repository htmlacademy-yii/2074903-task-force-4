<?php
namespace app\controllers;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\models\form\RegistrationForm;
use omarinina\domain\models\Cities;
use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;

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
     * @return string|Response
     * @throws Exception
     */
    public function actionIndex(): string|Response
    {
        $registrationForm = new RegistrationForm();
        $cities = Cities::find()->all();
        $newUser = new Users();

        if (Yii::$app->request->getIsPost()) {
            $registrationForm->load(Yii::$app->request->post());

            if ($registrationForm->validate()) {
                $newUser->attributes = Yii::$app->request->post('RegistrationForm');
                $newUser->email = mb_strtolower($registrationForm->email);
                $newUser->password = Yii::$app->getSecurity()->generatePasswordHash($registrationForm->password);
                $newUser->role =  ($registrationForm->executor === true) ? 2 : 1;
                $newUser->save(false);

                return $this->redirect(['site/index']);
            }
        }

        return $this->render('index', [
            'model' => $registrationForm,
            'cities' => $cities
            ]);
    }
}
