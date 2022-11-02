<?php
/** @var $this View */
/** @var SecurityProfileForm $model */

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\models\form\SecurityProfileForm;
use yii\web\View;
use app\widgets\ProfileNavigationWidget;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/main.js');
?>

<div class="main-content main-content--left container">
    <?= ProfileNavigationWidget::widget([]) ?>
    <div class="my-profile-form">
        <?php $form = ActiveForm::begin([
            'id' => 'security-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label'],
                'errorOptions' => ['tag' => 'span', 'class' => 'help-block']
            ]
        ])
?>
            <h3 class="head-main head-regular">Смена пароля</h3>
            <?= $form->field($model, 'currentPassword', ['options' => ['class' => 'form-group']])
                ->passwordInput(['placeholder' => 'Введите ваш пароль']); ?>
            <?= $form->field($model, 'newPassword', ['options' => ['class' => 'form-group']])
                ->passwordInput(['placeholder' => 'Придумайте новый пароль']); ?>
            <?= $form->field($model, 'repeatedPassword', ['options' => ['class' => 'form-group']])
                ->passwordInput(['placeholder' => 'Повторите пароль']); ?>

        <input type="submit" class="button button--blue" value="Сохранить">
        <?php ActiveForm::end(); ?>
    </div>
</div>
