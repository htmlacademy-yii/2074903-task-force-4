<?php
namespace app\controllers;

use omarinina\application\services\user\show\ServiceUserShow;
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
        try {
            if ($id) {
                $userProfile = ServiceUserShow::getUserExecutorById($id);
            } else {
                throw new NotFoundHttpException('Task is not found', 404);
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
