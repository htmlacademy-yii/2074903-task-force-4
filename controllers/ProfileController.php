<?php
namespace app\controllers;

use app\controllers\SecurityController;
use omarinina\domain\models\user\Users;
use yii\web\NotFoundHttpException;

class ProfileController extends SecurityController
{
    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException|\yii\base\InvalidConfigException
     */
    public function actionView(int $id): string
    {
        if ($id) {
            $currentUser = Users::findOne($id);
            if (!$currentUser || $currentUser->userRole->role !== 'executor') {
                throw new NotFoundHttpException('Task is not found', 404);
            }
        } else {
            throw new NotFoundHttpException('Task is not found', 404);
        }

        return $this->render('view', [
            'currentUser' => $currentUser
        ]);
    }
}
