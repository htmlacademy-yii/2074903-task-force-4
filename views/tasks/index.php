<?php

declare(strict_types=1);

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\widgets\TaskWidget;
use yii\widgets\LinkPager;
use omarinina\infrastructure\constants\ViewConstants;

/** @var yii\web\View $this */
/** @var omarinina\domain\models\task\Tasks[] $newTasks */
/** @var omarinina\domain\models\Categories[] $categories */
/** @var omarinina\infrastructure\models\form\TaskFilterForm $model */
/** @var \yii\data\Pagination $pagination */

?>

<div class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?php if (!$newTasks) : ?>
        <p>Свободных заданий пока нет.</p>
        <?php endif; ?>
        <?php foreach ($newTasks as $newTask) : ?>
            <?= TaskWidget::widget(['task' => $newTask]) ?>
        <?php endforeach; ?>

        <div class="pagination-wrapper">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                    'options' => ['class' => 'pagination-list'],
                    'activePageCssClass' => 'pagination-item pagination-item--active',
                    'linkContainerOptions' => ['class' => 'pagination-item'],
                    'maxButtonCount' => ViewConstants::BUTTON_COUNT_PAGINATION,
                    'linkOptions' => ['class' => 'link link--page'],
                    'prevPageCssClass' => 'mark',
                    'nextPageCssClass' => 'mark',
                    'prevPageLabel' => '',
                    'nextPageLabel' => '',
                    'hideOnSinglePage' => true,
                ]) ?>
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
