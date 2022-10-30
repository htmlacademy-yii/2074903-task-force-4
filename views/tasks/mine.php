<?php

use app\widgets\TaskWidget;

/** @var yii\web\View $this */
/** @var omarinina\domain\models\task\Tasks[] $tasks */


?>

<div class="main-content container">
    <div class="left-menu">
        <h3 class="head-main head-task">Мои задания</h3>
        <ul class="side-menu-list">
            <li class="side-menu-item side-menu-item--active">
                <a class="link link--nav">Новые</a>
            </li>
            <li class="side-menu-item">
                <a href="#" class="link link--nav">В процессе</a>
            </li>
            <li class="side-menu-item">
                <a href="#" class="link link--nav">Закрытые</a>
            </li>
        </ul>
    </div>
    <div class="left-column left-column--task">
        <h3 class="head-main head-regular">Новые задания</h3>
        <?php if (!$tasks) : ?>
            <p>У вас пока нет заданий.</p>
        <?php endif; ?>
        <?php foreach ($tasks as $task) : ?>
            <?= TaskWidget::widget(['task' => $task]) ?>
        <?php endforeach; ?>
    </div>
</div>
