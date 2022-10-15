<?php
namespace app\controllers;

use omarinina\application\services\profile\show\ServiceProfileShow;
use yii\web\NotFoundHttpException;

class ProfileController extends SecurityController
{
    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        if ($id) {
            $userProfile = ServiceProfileShow::getUserProfile($id);
        } else {
            throw new NotFoundHttpException('Task is not found', 404);
        }

        return $this->render('view', [
            'currentUser' => $userProfile
        ]);
    }
}
