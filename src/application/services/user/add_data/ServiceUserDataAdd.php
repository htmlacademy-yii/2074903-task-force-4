<?php

namespace omarinina\application\services\user\add_data;

use omarinina\domain\models\user\Users;
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
}
