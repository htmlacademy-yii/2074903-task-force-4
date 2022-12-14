<?php

declare(strict_types=1);

/** @var $this View */
/** @var EditProfileForm $model */
/** @var Users $user */
/** @var Categories $categories */

use omarinina\domain\models\Categories;
use omarinina\infrastructure\models\form\EditProfileForm;
use yii\web\View;
use app\widgets\ProfileNavigationWidget;
use yii\widgets\ActiveForm;
use omarinina\domain\models\user\Users;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
use omarinina\infrastructure\constants\UserRoleConstants;
use yii\helpers\Html;

$model->categories = array_map(
    function ($executorCategories) {
        return $executorCategories->id;
    },
    $user->executorCategories
);

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
            'id' => 'edit-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label'],
                'errorOptions' => ['tag' => 'span', 'class' => 'help-block']
            ]
        ])
?>
        <h3 class="head-main head-regular">Мой профиль</h3>
        <div class="photo-editing">
            <div>
                <p class="form-label">Аватар</p>
                <img
                    class="avatar-preview"
                    src="<?= $user->avatarSrc ?>"
                    width="83" height="83"
                    alt="Текущий аватар пользователя">
            </div>
            <?= $form->field($model, 'avatar', [
                'template' => "<label class=\"button button--black\">Сменить аватар{input}",
                'inputOptions' => ['style' => 'display: none', 'hidden' => true],
            ])->fileInput(); ?>
        </div>

        <?= $form->field($model, 'name', ['options' => ['class' => 'form-group',]])
            ->textInput([
                'placeholder' => 'Иван Иванов',
                'value' => Html::encode($user->name)
            ]); ?>

        <div class="half-wrapper">
            <?= $form->field($model, 'email', ['options' => ['class' => ' form-group']])
                ->textInput([
                    'placeholder' => 'something@google.com',
                    'value' => Html::encode($user->email)
                ]); ?>
            <?= $form->field($model, 'birthDate', ['options' => ['class' => 'form-group']])
                ->input('date', ['value' => $user->birthDate]); ?>
        </div>
        <div class="half-wrapper">
            <?= $form->field($model, 'phone', ['options' => ['class' => 'form-group']])
                ->widget(MaskedInput::class, [
                    'mask' => '99999999999',
                    'options' => ['placeholder' => '79999999999', 'value' => $user->phone],

                ]) ?>
            <?= $form->field($model, 'telegram', ['options' => ['class' => ' form-group']])
                ->textInput([
                    'placeholder' => '@example',
                    'value' => Html::encode($user->telegram)
                ]); ?>
        </div>

        <?= $form->field($model, 'bio', ['options' => ['class' => 'form-group']])
            ->textarea([
                'placeholder' => 'Напишите о себе подробнее',
                'value' => Html::encode($user->bio)
            ]); ?>

        <?php if ($user->role === UserRoleConstants::ID_EXECUTOR_ROLE) : ?>
        <p class="form-label">Выбор специализаций</p>
            <?= $form->field($model, 'categories')->checkboxList(
                ArrayHelper::map($categories, 'id', 'name'),
                ['class' => 'form-group checkbox-profile control-label', 'unselect' => null]
            ) ?>

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
