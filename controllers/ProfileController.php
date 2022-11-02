<?php
namespace app\controllers;

use omarinina\application\services\user\show\ServiceUserShow;
use omarinina\domain\models\Categories;
use omarinina\infrastructure\models\form\EditProfileForm;
use yii\web\NotFoundHttpException;
use Yii;

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
        $editForm = new EditProfileForm();
        $user = Yii::$app->user->identity;
        $categories = Categories::find()->all();
        return $this->render('edit', [
            'model' => $editForm,
            'user' => $user,
            'categories' => $categories
        ]);
    }

    public function actionSecurity()
    {
        return $this->render('security');
    }
}
