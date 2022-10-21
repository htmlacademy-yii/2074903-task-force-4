<?php

namespace omarinina\application\services\user\show;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\constants\UserRoleConstants;
use yii\web\NotFoundHttpException;
use Yii;

class ServiceUserShow
{
    /**
     * @param $id
     * @return Users
     * @throws NotFoundHttpException
     */
    public static function getUserExecutorById($id) : Users
    {
        $currentUser = Yii::$app->db->cache(function () use ($id) {
            return Users::findOne($id);
        });
        if (!$currentUser || $currentUser->userRole->role !== UserRoleConstants::EXECUTOR_ROLE) {
            throw new NotFoundHttpException('User is not found', 404);
        }
        return $currentUser;
    }
}
