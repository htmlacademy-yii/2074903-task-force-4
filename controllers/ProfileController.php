<?php
namespace app\controllers;

use omarinina\application\services\user\add_data\ServiceUserDataAdd;
use omarinina\application\services\user\create\ServiceUserCreate;
use omarinina\application\services\user\show\ServiceUserShow;
use omarinina\domain\models\Categories;
use omarinina\domain\models\user\Users;
use omarinina\infrastructure\constants\UserRoleConstants;
use omarinina\infrastructure\models\form\EditProfileForm;
use omarinina\infrastructure\models\form\SecurityProfileForm;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

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
//        } catch (\Throwable $e) {
//            return $e->getMessage() . 'Something wrong. Sorry, please, try again later';
        }
    }

    public function actionEdit()
    {
        $editForm = new EditProfileForm();
        $user = Yii::$app->user->identity;
        $categories = Categories::find()->all();

        if (Yii::$app->request->getIsPost()) {
            $editForm->load(Yii::$app->request->post());

            if ($editForm->validate()) {
                $newUser = ServiceUserCreate::createNewUser(
                    $registrationForm,
                    Yii::$app->request->post('RegistrationForm'),
                );
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }

        return $this->render('edit', [
            'model' => $editForm,
            'user' => $user,
            'categories' => $categories
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionSecurity() : Response|string
    {
        try {
            $securityForm = new SecurityProfileForm();
            $user = Yii::$app->user->identity;

            if (Yii::$app->request->getIsPost()) {
                $securityForm->load(Yii::$app->request->post());

                if ($securityForm->validate()) {
                    ServiceUserDataAdd::updateUserPassword(
                        $securityForm,
                        $user
                    );
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
