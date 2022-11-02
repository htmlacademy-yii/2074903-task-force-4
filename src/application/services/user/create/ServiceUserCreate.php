<?php

namespace omarinina\application\services\user\create;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\constants\UserRoleConstants;
use omarinina\infrastructure\constants\ViewConstants;
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
     * @param array|null $userData
     * @return Users|null
     * @throws Exception
     * @throws ServerErrorHttpException
     */
    public static function createNewUser(RegistrationForm $form, array $attributes, ?array $userData) : ?Users
    {
        $createdUser = new Users();
        $createdUser->attributes = $attributes;
        if ($userData) {
            $createdUser->vkId = $userData['id'];
        }
        $createdUser->avatarSrc = ViewConstants::DEFAULT_AVATARS[array_rand(ViewConstants::DEFAULT_AVATARS, 1)];
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
}
