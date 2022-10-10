<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
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
            <div class="form-group">
                <label class="control-label" for="essence-work">Опишите суть работы</label>
                <input id="essence-work" type="text">
                <span class="help-block">Error description is here</span>
            </div>
            <div class="form-group">
                <label class="control-label" for="username">Подробности задания</label>
                <textarea id="username"></textarea>
                <span class="help-block">Error description is here</span>
            </div>
            <div class="form-group">
                <label class="control-label" for="town-user">Категория</label>
                <select id="town-user">
                    <option>Курьерские услуги</option>
                    <option>Грузоперевозки</option>
                    <option>Клининг</option>
                </select>
                <span class="help-block">Error description is here</span>
            </div>
            <div class="form-group">
                <label class="control-label" for="location">Локация</label>
                <input class="location-icon" id="location" type="text">
                <span class="help-block">Error description is here</span>
            </div>
            <div class="half-wrapper">
                <div class="form-group">
                    <label class="control-label" for="budget">Бюджет</label>
                    <input class="budget-icon" id="budget" type="text">
                    <span class="help-block">Error description is here</span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="period-execution">Срок исполнения</label>
                    <input id="period-execution" type="date">
                    <span class="help-block">Error description is here</span>
                </div>
            </div>
            <p class="form-label">Файлы</p>
            <div class="new-file">
                Добавить новый файл
            </div>
            <input type="submit" class="button button--blue" value="Опубликовать">
        <?php ActiveForm::end(); ?>
    </div>
</div>
