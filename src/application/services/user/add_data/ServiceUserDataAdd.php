<?php

namespace omarinina\application\services\user\add_data;

use omarinina\domain\models\user\Users;
use yii\web\ServerErrorHttpException;

class ServiceUserDataAdd
{
    /**
     * @param Users $user
     * @param array $attributes
     * @return Users
     * @throws ServerErrorHttpException
     */
    public static function addUserVkId(Users $user, array $attributes) : Users
    {
        $user->vkId = $attributes['id'];

        if (!$user->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }

        return $user;
    }
}
