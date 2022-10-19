<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;

Modal::begin([
    'id' => 'denial-form',
    'options' => [
        'class' => 'pop-up pop-up--refusal pop-up--close',
    ],
    'closeButton' => false,
]);

?>

<div class="pop-up--wrapper">
    <h4>Отказ от задания</h4>
    <p class="pop-up-text">
        <b>Внимание!</b><br>
        Вы собираетесь отказаться от выполнения этого задания.<br>
        Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
    </p>

    <?php
    echo Html::submitButton('Отказаться', ['class' => 'button button--pop-up button--orange']);
    ?>

    <div class="button-container">
        <?php
        echo Html::button('Закрыть окно', ['class' => 'button--close', 'data-bs-dismiss' => 'modal']);
        ?>
    </div>
</div>

<?php Modal::end(); ?>
