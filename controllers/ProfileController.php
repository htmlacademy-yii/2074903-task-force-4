<?php

declare(strict_types=1);

namespace app\controllers;

use omarinina\application\services\file\parse\ServiceFileParse;
use omarinina\application\services\user\addData\ServiceUserCategoriesUpdate;
use omarinina\application\services\user\show\ServiceUserShow;
use omarinina\domain\models\Categories;
use omarinina\domain\models\user\Users;
use omarinina\infrastructure\models\form\EditProfileForm;
use omarinina\infrastructure\models\form\SecurityProfileForm;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

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
                $currentUser = Yii::$app->user->id;
                $userProfile = ($currentUser === $id) ?
                    Users::findOne($id) :
                    ServiceUserShow::getUserExecutorById($id);
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

    /**
     * @return string|Response
     * @throws \Throwable
     */
    public function actionEdit() : Response|string
    {
        try {
            $editForm = new EditProfileForm();
            $user = Yii::$app->user->identity;
            $categories = Categories::find()->all();

            if (Yii::$app->request->getIsPost()) {
                $editForm->load(Yii::$app->request->post());

                if ($editForm->validate()) {
                    $avatar = UploadedFile::getInstance($editForm, 'avatar');
                    $avatarSrc = ServiceFileParse::parseAvatarFile($avatar);
                    $user->updateProfile($editForm, $avatarSrc);
                    ServiceUserCategoriesUpdate::updateExecutorCategories($user, $editForm->categories);
                    return $this->redirect(['view', 'id' => $user->id]);
                }
            }

            return $this->render('edit', [
                'model' => $editForm,
                'user' => $user,
                'categories' => $categories
            ]);
        } catch (ServerErrorHttpException|InvalidConfigException $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSecurity() : Response|string
    {
        try {
            $securityForm = new SecurityProfileForm();
            $user = Yii::$app->user->identity;

            if ($user->vkId) {
                return $this->redirect(['edit']);
            }

            if (Yii::$app->request->getIsPost()) {
                $securityForm->load(Yii::$app->request->post());

                if ($securityForm->validate()) {
                    $user->updatePassword($securityForm->newPassword);

                    return $this->redirect(['view', 'id' => $user->id]);
                }
            }

            return $this->render('security', [
                'model' => $securityForm,
            ]);
        } catch (\yii\web\ServerErrorHttpException|\Exception $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return 'Something wrong. Sorry, please, try again later';
        }
    }
}
