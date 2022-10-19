<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;

Modal::begin([
    'id' => 'cancellation-form',
    'options' => [
        'class' => 'pop-up pop-up--refusal pop-up--close',
    ],
    'closeButton' => false,
]);

?>

    <div class="pop-up--wrapper">
        <h4>Отмена задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отменить ваше задание.<br>
            Оно пропадёт из поиска и не сможет быть выполненным.
        </p>

        <?php
        echo Html::submitButton('Отменить', ['class' => 'button button--pop-up button--pink']);
        ?>

        <div class="button-container">
            <?php
            echo Html::button('Закрыть окно', ['class' => 'button--close', 'data-bs-dismiss' => 'modal']);
            ?>
        </div>
    </div>

<?php Modal::end(); ?>
