<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Modal;

/** @var omarinina\infrastructure\models\form\TaskResponseForm $model */

Modal::begin([
    'id' => 'response-form',
    'options' => [
        'class' => 'pop-up pop-up--act_response pop-up--close',
    ],
    'closeButton' => false,
]);


?>

    <div class="pop-up--wrapper">
    <h4>Добавление отклика к заданию</h4>
    <p class="pop-up-text">
        Вы собираетесь оставить свой отклик к этому заданию.
        Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
    </p>
    <div class="addition-form pop-up--form regular-form">

<?php
$form = ActiveForm::begin([
    'id' => 'response-form',
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'control-label'],
        'errorOptions' => ['tag' => 'span', 'class' => 'help-block']
    ],
    'action' => ['task-actions/respond-task']
]);
?>

    <p>
        <?= $form->field($model, 'comment', ['options' => ['class' => 'form-group']])
            ->textarea(['placeholder' => 'Напишите то, что важно']); ?>
    </p>
    <p>
        <?= $form->field($model, 'price', ['options' => ['class'=> 'form-group']])
            ->textInput(['placeholder' => '1000']); ?>
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
