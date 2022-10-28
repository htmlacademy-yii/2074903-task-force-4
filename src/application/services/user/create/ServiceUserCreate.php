<?php

namespace omarinina\application\services\user\create;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\constants\UserRoleConstants;
use omarinina\infrastructure\models\form\RegistrationForm;
use yii\base\Exception;
use yii\web\ServerErrorHttpException;
use Yii;

class ServiceUserCreate
{
    /**
     * @param RegistrationForm $form
     * @param array $attributes
     * @return Users|null
     * @throws ServerErrorHttpException
     * @throws Exception
     */
    public static function createNewUser(RegistrationForm $form, array $attributes) : ?Users
    {
        $createdUser = new Users();
        $createdUser->attributes = $attributes;
        $createdUser->email = mb_strtolower($form->email);
        $createdUser->password = Yii::$app->getSecurity()->generatePasswordHash($form->password);
        $createdUser->role =  ($form->executor === true) ?
            UserRoleConstants::ID_EXECUTOR_ROLE :
            UserRoleConstants::ID_CLIENT_ROLE;

        if (!$createdUser->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }

        return $createdUser;
    }

    public static function createNewUserByVk()
    {

    }
}
