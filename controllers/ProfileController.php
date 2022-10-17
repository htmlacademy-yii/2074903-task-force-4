<?php
namespace app\controllers;

use omarinina\application\services\user\show\ServiceProfileShow;
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
        try {
            if ($id) {
                $userProfile = ServiceProfileShow::getUserProfile($id);
            } else {
                throw new NotFoundHttpException('User is not found', 404);
            }

            return $this->render('view', [
                'currentUser' => $userProfile
            ]);
        } catch (NotFoundHttpException|
            \Exception|
            \yii\base\InvalidConfigException $e) {
            return $e->getMessage();
        }
    }
}
