<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use omarinina\infrastructure\models\form\TaskFilterForm;

/** @var yii\web\View $this */
/** @var omarinina\domain\models\task\Tasks $newTasks */
/** @var omarinina\domain\models\Categories $categories */
/** @var omarinina\infrastructure\models\form\TaskFilterForm $model */

/**
 * Counts how much time ago this task was created by days/hours/minutes
 *
 * @param $createAt
 * @return string
 * @throws Exception
 */
function countTimeAgoPost($createAt):string
{
    $unixCreateAt = Yii::$app->formatter->asTimestamp($createAt);
    $unixNow = Yii::$app->formatter->asTimestamp(new DateTime('now'));
    $diff = $unixNow - $unixCreateAt;

    if ($diff/86400 >= 1) {
        return morphos\Russian\pluralize(floor($diff/86400), 'день');
    } elseif ($diff/3600 >= 1) {
        return morphos\Russian\pluralize(floor($diff/3600), 'час');
    }
    return morphos\Russian\pluralize(floor($diff/60), 'минута');
}
?>

<div class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?php foreach ($newTasks as $newTask): ?>
        <div class="task-card">
            <div class="header-task">
                <a  href="#" class="link link--block link--big"><?= $newTask->name; ?></a>
                <p class="price price--task"><?= $newTask->budget; ?> ₽</p>
            </div>
            <p class="info-text"><span class="current-time"><?= countTimeAgoPost($newTask->createAt) ?></span> назад</p>
            <p class="task-text"><?= $newTask->description; ?></p>
            <div class="footer-task">
                <?php if(isset($newTask->city->name)): ?>
                <p class="info-text town-text"><?= $newTask->city->name; ?></p>
                <?php endif; ?>
                <p class="info-text category-text"><?= $newTask->category->name ?></p>
                <a href="#" class="button button--black">Смотреть Задание</a>
            </div>
        </div>
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
                        checkboxList(ArrayHelper::map($categories, 'id', 'name'),
                            ['class' => 'form-group checkbox-wrapper control-label']) ?>

                <h4 class="head-card">Дополнительно</h4><br>
                    <?= $form->field($model, 'noResponds')
                        ->checkbox(['class' => 'form-group control-label']); ?>
                    <?= $form->field($model, 'remote')
                        ->checkbox(['class' => 'form-group control-label']); ?>
                    <?= $form->field($model, 'period', ['options' => ['class' => 'head-card']])
                        ->dropDownList($model->getPeriods(), ['class' => 'form-group', 'prompt' => '-выбрать-']) ?>
                    <input type="submit" class="button button--blue" value="Искать">
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
