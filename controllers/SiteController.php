<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use omarinina\infrastructure\models\form\LoginForm;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->user->loginUrl = ['site/index'];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string|Response
     */
    public function actionIndex() : string|Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'landing';
        return $this->render('index');
    }

    /**
     * @return array|string|Response
     */
    public function actionAjaxLogin() : array|string|Response
    {
        try {
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            if (Yii::$app->request->isAjax) {
                $loginForm = new LoginForm();
                if ($loginForm->load(Yii::$app->request->post())) {
                    if ($loginForm->login()) {
                        return $this->goHome();
                    }
                    Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                    return \yii\widgets\ActiveForm::validate($loginForm);
                }
            } else {
                throw new NotFoundHttpException('Page not found', 404);
            }
        } catch (NotFoundHttpException $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            Yii::$app->errorHandler->logException($e);
            return 'Something wrong. Sorry, please, try again later';
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['index']);
    }
}
