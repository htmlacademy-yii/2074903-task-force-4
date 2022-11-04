<?php

declare(strict_types=1);

namespace omarinina\application\services\user\addData;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\models\form\EditProfileForm;
use omarinina\infrastructure\models\form\SecurityProfileForm;
use yii\base\InvalidConfigException;
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

    /**
     * @param Users $user
     * @param EditProfileForm $form
     * @param string|null $avatarSrc
     * @return void
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public static function updateUserProfile(Users $user, EditProfileForm $form, ?string $avatarSrc = null) : void
    {
        if (!$user->updateProfile($form, $avatarSrc)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
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
