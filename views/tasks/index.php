<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\widgets\TaskWidget;

/** @var yii\web\View $this */
/** @var omarinina\domain\models\task\Tasks[] $newTasks */
/** @var omarinina\domain\models\Categories[] $categories */
/** @var omarinina\infrastructure\models\form\TaskFilterForm $model */

?>

<div class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?php foreach ($newTasks as $newTask) : ?>
            <?= TaskWidget::widget(['task' => $newTask]) ?>
        <?php endforeach; ?>

        <div class="pagination-wrapper">
            <ul class="pagination-list">
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">1</a>
                </li>
                <li class="pagination-item pagination-item--active">
                    <a href="#" class="link link--page">2</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">3</a>
                </li>
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'search-form'
                ])
                ?>
                <h4 class="head-card">Категории</h4>
                    <?= $form->field($model, 'categories')->
                        checkboxList(
                            ArrayHelper::map($categories, 'id', 'name'),
                            ['class' => 'form-group checkbox-wrapper control-label', 'unselect' => null]
                        ) ?>

                <h4 class="head-card">Дополнительно</h4><br>
                    <?= $form->field($model, 'noResponds')
                        ->checkbox(['class' => 'form-group control-label', 'unselect' => null]); ?>
                    <?= $form->field($model, 'remote')
                        ->checkbox(['class' => 'form-group control-label', 'unselect' => null]); ?>
                    <?= $form->field($model, 'period', ['options' => ['class' => 'head-card']])
                        ->dropDownList($model->getPeriods(), ['class' => 'form-group', 'prompt' => '-выбрать-']) ?>
                    <input type="submit" class="button button--blue" value="Искать">
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
