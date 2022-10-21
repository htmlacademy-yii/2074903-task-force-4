<?php

namespace omarinina\application\services\user\show;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\constants\UserRoleConstants;
use yii\web\NotFoundHttpException;

class ServiceUserShow
{
    /**
     * @param $id
     * @return Users
     * @throws NotFoundHttpException
     */
    public static function getUserExecutorById($id) : Users
    {
        $currentUser = Users::findOne($id);
        if (!$currentUser || $currentUser->userRole->role !== UserRoleConstants::EXECUTOR_ROLE) {
            throw new NotFoundHttpException('Task is not found', 404);
        }
        return $currentUser;
    }
}
