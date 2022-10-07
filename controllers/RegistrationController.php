<?php
namespace app\controllers;

use omarinina\infrastructure\models\form\RegistrationForm;
use omarinina\domain\models\Cities;
use Yii;
use yii\web\Controller;

class RegistrationController extends Controller
{

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionIndex(): string
    {
        $registrationForm = new RegistrationForm();
        $cities = Cities::find()->all();

        if (Yii::$app->request->getIsPost()) {
            $registrationForm->load(Yii::$app->request->post());

            if ($registrationForm->validate()) {
                $registrationForm->createNewUser();
                $this->goHome();
            }
        }

        return $this->render('index', [
            'model' => $registrationForm,
            'cities' => $cities
            ]);
    }
}
