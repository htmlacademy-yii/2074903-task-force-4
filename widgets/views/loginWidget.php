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
?>
        <form action="#" method="post">
            <p>
                <label class="form-modal-description" for="enter-email">Email</label>
                <input class="enter-form-email input input-middle" type="email" name="enter-email" id="enter-email">
            </p>
            <p>
                <label class="form-modal-description" for="enter-password">Пароль</label>
                <input class="enter-form-email input input-middle" type="password" name="enter-email" id="enter-password">
            </p>
            <button class="button" type="submit">Войти</button>
        </form>
        <button class="form-modal-close" type="button">Закрыть</button>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'enableAjaxValidation' => true,
    'action' => ['site/ajax-login']
]);
echo $form->field($model, 'email')->textInput();
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model, 'rememberMe')->checkbox();
?>

    <div>
        If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
    </div>
    <div class="form-group">
        <div class="text-right">

            <?php
            echo Html::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']);
            echo Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']);
            ?>

        </div>
    </div>

<?php
ActiveForm::end();
Modal::end();
