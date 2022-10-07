<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var omarinina\infrastructure\models\form\RegistrationForm $model */
/** @var omarinina\domain\models\Cities $cities */

?>
<div class="container container--registration">
    <div class="center-block">
        <div class="registration-form regular-form">
            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'control-label'],
                    'errorOptions' => ['tag' => 'span', 'class' => 'help-block']
                ]
            ])
            ?>
                <h3 class="head-main head-task">Регистрация нового пользователя</h3>
                <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])
                    ->textInput(['placeholder' => 'Иван Иванов']); ?>

                <div class="half-wrapper">
                    <?= $form->field($model, 'email', ['options' => ['class' => ' form-group']])
                        ->textInput(['placeholder' => 'something@google.com']); ?>
                    <?= $form->field($model, 'city', ['options' => ['class' => 'form-group']])
                        ->dropDownList(ArrayHelper::map($cities, 'id', 'name'), ['class' => 'form-group']); ?>
                </div>
                <?= $form->field($model, 'password', ['options' => ['class' => 'half-wrapper form-group']])
                    ->passwordInput(['placeholder' => 'пароль']); ?>
                <?= $form->field($model, 'repeatedPassword', ['options' => ['class' => 'half-wrapper form-group']])
                    ->passwordInput(['placeholder' => 'повторите пароль']); ?>
                <?= $form->field($model, 'executor', ['options' => ['class' => 'form-group']])->checkbox(['class' => 'control-label checkbox-label']) ?>

                <input type="submit" class="button button--blue" value="Создать аккаунт">
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
