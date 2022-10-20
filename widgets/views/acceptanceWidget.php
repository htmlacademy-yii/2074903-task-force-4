<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Modal;

/** @var omarinina\infrastructure\models\form\TaskResponseForm $model */

Modal::begin([
    'id' => 'acceptance-form',
    'options' => [
        'class' => 'pop-up pop-up--act_response pop-up--close',
    ],
    'closeButton' => false,
]);


?>

    <div class="pop-up--wrapper">
    <h4>Завершение задания</h4>
    <p class="pop-up-text">
        Вы собираетесь отметить это задание как выполненное.
        Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
    </p>
    <div class="completion-form pop-up--form regular-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'acceptance-form',
            'enableAjaxValidation' => true,
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label'],
                'errorOptions' => ['tag' => 'span', 'class' => 'help-block']
            ],
            'action' => ['task-actions/accept-task']
        ]);
        ?>

        <p>
            <?= $form->field($model, 'comment', ['options' => ['class' => 'form-group']])
                ->textarea(['placeholder' => 'Напишите то, что важно']); ?>
        </p>
        <p>
            <?= $form->field($model, 'score', ['options' => ['class'=> 'completion-head control-label']])
                ->textInput(['placeholder' => 'Оцените работу от 1 до 5']); ?>
        </p>

        <?php
        echo Html::submitInput('Завершить', ['class' => 'button button--pop-up button--blue']);

        ActiveForm::end();

        ?>
        <div class="button-container">
            <?php
            echo Html::button('Закрыть', ['class' => 'button--close', 'data-bs-dismiss' => 'modal']);
            ?>
        </div>
    </div>
<?php Modal::end(); ?>
