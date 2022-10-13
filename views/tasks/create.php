<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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


            <div class="form-group">
                <label class="control-label" for="location">Локация</label>
                <input class="location-icon" id="location" type="text" placeholder="Оставьте это поле пустым">
                <span class="help-block">Error description is here</span>
            </div>

            <div class="half-wrapper">
                <?= $form->field($model, 'budget', ['options' => ['class' => 'form-group']])
                    ->textInput(['placeholder' => '1000', 'class' => 'budget-icon']); ?>
                <?= $form->field($model, 'expiryDate', ['options' => ['class' => 'form-group']])
                    ->input('date'); ?>
            </div>

            <p class="form-label">Файлы</p>
            <?= $form->field($model, 'files[]', [
                'template' => "<label class=\"new-file\" >Добавить новый файл{input}",
                'inputOptions' => ['style' => 'display: none'],
            ])->fileInput(['multiple' => true]); ?>

            <?= Html::submitInput('Опубликовать', ['class' => 'button button--blue']); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
