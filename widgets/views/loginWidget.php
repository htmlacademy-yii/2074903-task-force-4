<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;

Modal::begin([
    'header'=>'<h2>Вход на сайт</h2>',
    'id'=>'login-modal',
    'options' => [
        'class' => 'modal enter-form form-modal'
    ]
]);

$form = ActiveForm::begin([
    'id' => 'login-form',
    'enableAjaxValidation' => true,
    'action' => ['site/ajax-login']
]);
echo $form->field($model, 'email')->textInput(['placeholder' => 'example@google.com']);
echo $form->field($model, 'password')->passwordInput(['placeholder' => 'введите ваш пароль']);

echo Html::button('Закрыть', ['class' => 'form-modal-close', 'data-dismiss' => 'modal']);
echo Html::submitButton('Войти', ['class' => 'button']);

ActiveForm::end();
Modal::end();
