<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Modal;

/** @var omarinina\infrastructure\models\form\LoginForm $model */

Modal::begin([
    'id' => 'enter-form',
    'options' => [
        'class' => 'modal enter-form form-modal',
    ],
    'closeButton' => false,
]);


?>

    <h2>Вход на сайт</h2>

<?php
$form = ActiveForm::begin([
    'id' => 'login-form',
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'form-modal-description'],
        'errorOptions' => ['tag' => 'span', 'class' => 'help-block']
    ],
    'action' => ['site/ajax-login']
]);
?>

<p>
<?= $form->field($model, 'email', ['options' => ['class' => 'enter-form-email input input-middle']])
    ->textInput(['placeholder' => 'example@google.com']); ?>
</p>
<p>
<?= $form->field($model, 'password', ['options' => ['class'=> 'enter-form-email input input-middle']])
    ->passwordInput(['placeholder' => 'введите ваш пароль']); ?>
</p>

<?php
echo Html::submitButton('Войти', ['class' => 'button']);

ActiveForm::end();

echo Html::button('Закрыть', ['class' => 'form-modal-close', 'data-bs-dismiss' => 'modal']);
?>
<?php Modal::end(); ?>
