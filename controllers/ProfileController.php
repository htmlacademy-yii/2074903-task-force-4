<?php
namespace app\controllers;

use yii\web\Controller;
use omarinina\domain\models\user\Users;
use omarinina\infrastructure\statistic\ExecutorStatistic;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        if ($id) {
            $currentUser = Users::findOne($id);
            $executorStatistic = new ExecutorStatistic($id);
            if (!$currentUser || $currentUser->userRole->role !== 'executor') {
                throw new NotFoundHttpException('Task is not found', 404);
            }
        } else {
            throw new NotFoundHttpException('Task is not found', 404);
        }

        return $this->render('view', [
            'currentUser' => $currentUser,
            'executorStatistic' => $executorStatistic
        ]);
    }
}
