<?php

namespace omarinina\application\services\user\show;

use omarinina\domain\models\user\Users;
use yii\web\NotFoundHttpException;

class ServiceProfileShow
{
    /**
     * @param $id
     * @return Users
     * @throws NotFoundHttpException
     */
    public static function getUserProfile($id) : Users
    {
        $currentUser = Users::findOne($id);
        if (!$currentUser || $currentUser->userRole->role !== 'executor') {
            throw new NotFoundHttpException('Task is not found', 404);
        }
        return $currentUser;
    }
}
