<?php
namespace app\controllers;

use omarinina\infrastructure\models\form\RegistrationForm;
use omarinina\domain\models\Cities;
use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;

class RegistrationController extends Controller
{

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionIndex(): string|Response
    {
        $registrationForm = new RegistrationForm();
        $cities = Cities::find()->all();

        if (Yii::$app->request->getIsPost()) {
            $registrationForm->load(Yii::$app->request->post());

            if ($registrationForm->validate()) {
                $registrationForm->createNewUser();
                return $this->goHome();
            }
        }

        return $this->render('index', [
            'model' => $registrationForm,
            'cities' => $cities
            ]);
    }
}
