<?php
/** @var $this View */
/** @var SecurityProfileForm $model */
/** @var Users $user */

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\models\form\SecurityProfileForm;
use yii\web\View;
use app\widgets\ProfileNavigationWidget;
use yii\widgets\ActiveForm;
use omarinina\infrastructure\constants\UserRoleConstants;

if ($user->hidden) {
    $checked = 'checked';
} else {
    $checked = null;
}

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
        <?php if ($user->role === UserRoleConstants::ID_EXECUTOR_ROLE) : ?>
            <?= $form->field(
                $model,
                'hidden',
                ['options' => ['class' => 'form-group']]
            )->checkbox(['class' => 'control-label checkbox-label', 'checked' => $checked]) ?>
        <?php endif; ?>

        <input type="submit" class="button button--blue" value="Сохранить">
        <?php ActiveForm::end(); ?>
    </div>
</div>
