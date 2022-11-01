<?php
namespace app\controllers;

use omarinina\application\services\user\show\ServiceUserShow;
use yii\web\NotFoundHttpException;

class ProfileController extends SecurityController
{
    /**
     * @param int $id
     * @return string
     */
    public function actionView(int $id): string
    {
        try {
            if ($id) {
                $userProfile = ServiceUserShow::getUserExecutorById($id);
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
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionSecurity()
    {
        return $this->render('security');
    }
}
