<?php

use app\widgets\assets\TaskWidgetAsset;
use omarinina\domain\models\task\Tasks;
use yii\helpers\Url;

/** @var Tasks $task */

TaskWidgetAsset::register($this);
?>

<div class="task-card">
    <div class="header-task">
        <a  href="<?= Url::to(['tasks/view', 'id' => $task->id]) ?>" class="link link--block link--big">
            <?= $task->name; ?></a>
        <p class="price price--task"><?= $task->budget; ?> ₽</p>
    </div>
    <p class="info-text"><span class="current-time">
                    <?= $task->countTimeAgoPost($task->createAt) ?>
                </span> назад</p>
    <p class="task-text"><?= $task->description; ?></p>
    <div class="footer-task">
        <?php if (isset($task->location)) : ?>
            <p class="info-text town-text"><?= $task->location; ?></p>
        <?php endif; ?>
        <p class="info-text category-text"><?= $task->category->name ?></p>
        <a href="<?= Url::to(['tasks/view', 'id' => $task->id]) ?>" class="button button--black">
            Смотреть Задание</a>
    </div>
</div>
