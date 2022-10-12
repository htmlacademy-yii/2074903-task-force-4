<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use \yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var omarinina\domain\models\Categories $categories */
/** @var omarinina\infrastructure\models\form\CreateTaskForm $model */

?>
<div class="main-content main-content--center container">
    <div class="add-task-form regular-form">
        <?php $form = ActiveForm::begin([
            'id' => 'create-task-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label'],
                'errorOptions' => ['tag' => 'span', 'class' => 'help-block']
            ]
        ])
?>
            <h3 class="head-main head-main">Публикация нового задания</h3>
            <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])
                ->textInput(['placeholder' => 'Сделать нормальную вёрстку для сайта']); ?>

            <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])
                ->textarea(['placeholder' => 'Опишите больше подробностей задания']); ?>

            <?= $form->field($model, 'categoryId', ['options' => ['class' => 'form-group']])
                ->dropDownList(
                    ArrayHelper::map($categories, 'id', 'name'),
                    ['class' => 'form-group', 'prompt' => '-выбрать-']
                ); ?>

            <?= $form->field($model, 'cityId', ['options' => ['class' => 'form-group']])
                ->textInput(['placeholder' => 'Оставьте это поле пустым', 'class' => 'location-icon']); ?>
<!--            <div class="form-group">-->
<!--                <label class="control-label" for="location">Локация</label>-->
<!--                <input class="location-icon" id="location" type="text">-->
<!--                <span class="help-block">Error description is here</span>-->
<!--            </div>-->

            <div class="half-wrapper">
                <?= $form->field($model, 'budget', ['options' => ['class' => 'form-group']])
                    ->textInput(['placeholder' => '1000', 'class' => 'budget-icon']); ?>
                <?= $form->field($model, 'expiryDate', ['options' => ['class' => 'form-group']])
                    ->widget(MaskedInput::class, ['mask' => '9999-99-99 99:99:99']); ?>
            </div>

            <?= $form->field($model, 'files[]', ['options' => ['class' => 'form-label']])
                ->fileInput(['multiple' => true, 'class' => 'new-file']); ?>
<!--            <p class="form-label">Файлы</p>-->
<!--            <div class="new-file">-->
<!--                Добавить новый файл-->
<!--            </div>-->
            <input type="submit" class="button button--blue" value="Опубликовать">
        <?php ActiveForm::end(); ?>
    </div>
</div>
