<?php

namespace omarinina\application\services\user\add_data;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\models\form\SecurityProfileForm;
use yii\web\ServerErrorHttpException;

class ServiceUserDataAdd
{
    /**
     * @param Users $user
     * @param array $attributes
     * @return void
     * @throws ServerErrorHttpException
     */
    public static function addUserVkId(Users $user, array $attributes) : void
    {
        $vkId = $attributes['id'];
        if (!$user->addVkId($vkId)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }

    public static function updateUserProfile()
    {

    }

    /**
     * @param SecurityProfileForm $form
     * @param Users $user
     * @return void
     * @throws ServerErrorHttpException
     * @throws \yii\base\Exception
     */
    public static function updateUserPassword(SecurityProfileForm $form, Users $user) : void
    {
        if (!$user->updatePassword($form->newPassword)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }
}
