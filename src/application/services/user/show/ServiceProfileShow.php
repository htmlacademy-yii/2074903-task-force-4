<?php

namespace omarinina\application\services\user\show;

use omarinina\domain\models\user\Users;
use yii\web\NotFoundHttpException;
use Yii;

class ServiceProfileShow
{
    /**
     * @param $id
     * @return Users
     * @throws NotFoundHttpException
     */
    public static function getUserProfile($id) : Users
    {
        $currentUser = Yii::$app->db->cache(function () use ($id) {
            return Users::findOne($id);
        });
        if (!$currentUser || $currentUser->userRole->role !== 'executor') {
            throw new NotFoundHttpException('User is not found', 404);
        }
        return $currentUser;
    }
}
