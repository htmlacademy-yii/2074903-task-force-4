<?php

use yii\authclient\clients\VKontakte;
use yii\authclient\Collection;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

/** @var omarinina\infrastructure\models\form\LoginForm $model */

/** @var Collection $collectionClientsOAuth */
$collectionClientsOAuth = Yii::$app->get('authClientCollection');

/** @var VKontakte $vkClientOAuth */
$vkClientOAuth = $collectionClientsOAuth->getClient('vkontakte');

$urlVkAuth = $vkClientOAuth->buildAuthUrl([
    'redirect_uri' => Url::to(['auth/authorize-user-via-vk'], 'http'),
    'response_type' => 'code',
    'scope' => 'email, offline'
]);


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
<div class="right-column">
    <?php
    echo Html::submitButton('Войти', ['class' => 'button']); ?>
</div>
<br>
<div class="left-column">
    <?php
    echo Html::a('Вход через вконтакте', $urlVkAuth, ['class'=>'button']);?>
</div>

<?php ActiveForm::end();

echo Html::button('Закрыть', ['class' => 'form-modal-close', 'data-bs-dismiss' => 'modal']);

Modal::end(); ?>
