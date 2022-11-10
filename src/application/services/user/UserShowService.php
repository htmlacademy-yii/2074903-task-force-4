<?php

declare(strict_types=1);

namespace omarinina\application\services\user;

use omarinina\application\services\user\interfaces\UserShowInterface;
use omarinina\domain\models\user\Users;
use omarinina\infrastructure\constants\UserRoleConstants;
use yii\web\NotFoundHttpException;

class UserShowService implements UserShowInterface
{
    /**
     * @param $id
     * @return Users
     * @throws NotFoundHttpException
     */
    public function getUserExecutorById($id) : Users
    {
        $currentUser = Users::findOne($id);
        if (!$currentUser || $currentUser->userRole->role !== UserRoleConstants::EXECUTOR_ROLE) {
            throw new NotFoundHttpException('User is not found', 404);
        }
        return $currentUser;
    }
}
