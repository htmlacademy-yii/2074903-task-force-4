<?php

namespace omarinina\application\services\user\create;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\constants\UserRoleConstants;
use omarinina\infrastructure\models\form\RegistrationCityRoleForm;
use omarinina\infrastructure\models\form\RegistrationForm;
use omarinina\infrastructure\models\form\RegistrationRoleForm;
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
    public static function createNewUser(RegistrationForm $form, array $attributes, ?array $userData) : ?Users
    {
        $createdUser = new Users();
        $createdUser->attributes = $attributes;
        if ($userData) {
            $createdUser->vkId = $userData['id'];
        }
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

    /**
     * @param array $userDataFromVk
     * @param RegistrationCityRoleForm|RegistrationRoleForm $form
     * @return Users
     * @throws Exception
     */
    public static function createNewUserByVk(
        array $userDataFromVk,
        RegistrationForm $form
    ) : Users {
        $createdUser = new Users();
        $form instanceof RegistrationCityRoleForm ?
            $createdUser->city = $form->city :
            $createdUser->city = $userDataFromVk['city']['title'];
        $createdUser->role =  ($form->executor === true) ?
            UserRoleConstants::ID_EXECUTOR_ROLE :
            UserRoleConstants::ID_CLIENT_ROLE;
        $createdUser->vkId = $userDataFromVk['id'];
        $createdUser->name = $userDataFromVk['first_name'] . $userDataFromVk['last_name'];
        $createdUser->email = mb_strtolower($userDataFromVk['email']);
        $userPassword = Yii::$app->security->generateRandomString(6);
        $createdUser->password = Yii::$app->getSecurity()->generatePasswordHash($userPassword);

        if (!$createdUser->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }

        return $createdUser;
    }
}
