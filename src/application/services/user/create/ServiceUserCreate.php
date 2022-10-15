<?php

namespace omarinina\application\services\user\create;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\models\form\RegistrationForm;
use yii\web\ServerErrorHttpException;
use Yii;

class ServiceUserCreate
{
    /**
     * @param RegistrationForm $form
     * @return void
     * @throws ServerErrorHttpException|\yii\base\Exception
     */
    public static function createNewUser(RegistrationForm $form) : void
    {
        $newUser = new Users();
        $newUser->attributes = Yii::$app->request->post('RegistrationForm');
        $newUser->email = mb_strtolower($form->email);
        $newUser->password = Yii::$app->getSecurity()->generatePasswordHash($form->password);
        $newUser->role =  ($form->executor === true) ? 2 : 1;
        $newUser->save(false);

        if (!Users::findOne($newUser->id)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }
}
